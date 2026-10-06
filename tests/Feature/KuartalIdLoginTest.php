<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Concerns\FakesKuartalId;
use Tests\TestCase;

/** "Masuk dengan Kuartal ID": OIDC authorization code + PKCE (S256) + state + nonce. Ported from careers. */
class KuartalIdLoginTest extends TestCase
{
    use FakesKuartalId, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpKuartalId();
    }

    public function test_redirect_sends_state_nonce_pkce_s256_and_default_scopes(): void
    {
        $response = $this->get('/auth/kuartal-id/redirect');

        $location = $response->assertRedirect()->headers->get('Location');
        $this->assertStringStartsWith(self::BASE.'/oauth/authorize?', $location);
        parse_str(parse_url($location, PHP_URL_QUERY), $query);

        $this->assertSame('code', $query['response_type']);
        $this->assertSame(self::CLIENT_ID, $query['client_id']);
        $this->assertSame('http://localhost/auth/kuartal-id/callback', $query['redirect_uri']);
        $this->assertSame('openid profile email', $query['scope']);

        $this->assertSame(40, strlen(session('kuartal_id.state')));
        $this->assertSame(session('kuartal_id.state'), $query['state']);
        $this->assertNotEmpty($query['nonce']);
        $this->assertSame(session('kuartal_id.nonce'), $query['nonce']);
        $this->assertNotSame($query['state'], $query['nonce']);

        $verifier = session('kuartal_id.verifier');
        $this->assertGreaterThanOrEqual(43, strlen($verifier));
        $this->assertSame('S256', $query['code_challenge_method']);
        $this->assertSame(rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '='), $query['code_challenge']);
    }

    public function test_each_redirect_uses_fresh_state_nonce_and_verifier(): void
    {
        $this->get('/auth/kuartal-id/redirect');
        $first = [session('kuartal_id.state'), session('kuartal_id.nonce'), session('kuartal_id.verifier')];
        $this->get('/auth/kuartal-id/redirect');
        $second = [session('kuartal_id.state'), session('kuartal_id.nonce'), session('kuartal_id.verifier')];

        foreach ([0, 1, 2] as $i) {
            $this->assertNotSame($first[$i], $second[$i]);
        }
    }

    public function test_configured_scopes_are_sent(): void
    {
        config(['services.kuartal_id.scopes' => 'openid profile email phone']);
        $location = $this->get('/auth/kuartal-id/redirect')->headers->get('Location');
        parse_str(parse_url($location, PHP_URL_QUERY), $query);

        $this->assertSame('openid profile email phone', $query['scope']);
    }

    public function test_unconfigured_client_shows_a_friendly_message(): void
    {
        config(['services.kuartal_id.client_id' => '']);

        $this->get('/auth/kuartal-id/redirect')->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
    }

    public function test_valid_sign_in_creates_the_account_and_sends_the_verifier_and_nonce(): void
    {
        $this->fakeKuartalId();

        $this->kuartalCallback()->assertRedirect(route('account'));

        $user = User::where('kuartal_id', 'kuartal-sub-1')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertSame('person@example.com', $user->email);
        $this->assertSame('Test Person', $user->name);
        $this->assertNotNull($user->email_verified_at);
        $this->assertFalse($user->is_admin);
        $this->assertSame('kuartal_id', session('auth.via'));
        Http::assertSent(fn (HttpRequest $r) => str_ends_with($r->url(), '/oauth/token')
            && $r['grant_type'] === 'authorization_code'
            && $r['code'] === 'test-code'
            && $r['code_verifier'] === str_repeat('v', 64)
            && $r['nonce'] === self::NONCE);
    }

    public function test_returning_user_signs_into_the_same_account(): void
    {
        $existing = User::factory()->create(['kuartal_id' => 'kuartal-sub-1', 'email' => 'person@example.com']);
        $this->fakeKuartalId();

        $this->kuartalCallback()->assertRedirect(route('account'));

        $this->assertAuthenticatedAs($existing);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_state_mismatch_is_rejected(): void
    {
        $this->fakeKuartalId();

        $this->withSession(['kuartal_id.state' => 'other-state', 'kuartal_id.nonce' => self::NONCE, 'kuartal_id.verifier' => str_repeat('v', 64)])
            ->get('/auth/kuartal-id/callback?state=test-state&code=test-code')
            ->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');

        $this->assertGuest();
        Http::assertNothingSent();
    }

    public function test_missing_state_or_verifier_in_session_is_rejected(): void
    {
        $this->fakeKuartalId();

        $this->kuartalCallback(['kuartal_id.state' => null])->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->kuartalCallback(['kuartal_id.verifier' => null])->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->assertGuest();
        Http::assertNothingSent();
    }

    public function test_state_cannot_be_replayed(): void
    {
        $this->fakeKuartalId();
        $this->kuartalCallback()->assertRedirect(route('account'));
        Auth::logout();

        // The session values were pulled on first use.
        $this->get('/auth/kuartal-id/callback?state=test-state&code=test-code')->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_provider_error_is_handled(): void
    {
        $this->get('/auth/kuartal-id/callback?error=access_denied')->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->assertGuest();
    }

    public function test_nonce_mismatch_is_rejected(): void
    {
        $this->fakeKuartalId(idToken: ['nonce' => 'some-other-nonce']);

        $this->kuartalCallback()->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_missing_id_token_is_rejected(): void
    {
        $this->fakeKuartalId(tokenResponse: ['id_token' => null]);

        $this->kuartalCallback()->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->assertGuest();
    }

    public function test_missing_nonce_in_session_is_rejected(): void
    {
        $this->fakeKuartalId();

        $this->kuartalCallback(['kuartal_id.nonce' => null])->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->assertGuest();
    }

    /** @return array<string, array{0: array<string, mixed>}> */
    public static function badIdTokens(): array
    {
        return [
            'wrong issuer' => [['iss' => 'https://evil.example']],
            'lookalike issuer' => [['iss' => 'https://id.kuartal.test.evil.example']],
            'wrong audience' => [['aud' => 'some-other-client']],
            'expired' => [['exp' => time() - 3600, 'iat' => time() - 7200]],
            'issued in the future' => [['iat' => time() + 3600]],
            'no nonce' => [['nonce' => null]],
            'no exp' => [['exp' => null]],
        ];
    }

    #[DataProvider('badIdTokens')]
    public function test_invalid_id_tokens_are_rejected(array $claims): void
    {
        $this->fakeKuartalId(idToken: $claims);

        $this->kuartalCallback()->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->assertGuest();
    }

    public function test_id_token_signed_with_an_unknown_key_is_rejected(): void
    {
        $other = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        openssl_pkey_export($other, $otherPrivate);
        $this->fakeKuartalId(tokenResponse: ['id_token' => $this->makeIdToken([], $otherPrivate)]);

        $this->kuartalCallback()->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->assertGuest();
    }

    public function test_userinfo_sub_must_match_id_token_sub(): void
    {
        $this->fakeKuartalId(userInfo: ['sub' => 'someone-else']);

        $this->kuartalCallback()->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->assertGuest();
    }

    public function test_kuartal_id_timeout_shows_a_friendly_error_not_a_500(): void
    {
        Http::fake(fn () => throw new ConnectionException('Connection timed out'));

        $this->kuartalCallback()->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
        $this->assertGuest();
    }

    public function test_kuartal_id_server_error_shows_a_friendly_error_not_a_500(): void
    {
        Http::fake([self::BASE.'/*' => Http::response(['error' => 'server_error'], 500)]);

        $this->kuartalCallback()->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');
    }

    public function test_email_already_used_by_another_kuartal_id_account_does_not_500(): void
    {
        $other = User::factory()->create(['email' => 'person@example.com', 'kuartal_id' => 'other-sub']);
        $this->fakeKuartalId();

        $this->kuartalCallback()->assertRedirect(route('account'));

        $user = User::where('kuartal_id', 'kuartal-sub-1')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertSame('kuartal-sub-1@kuartal-id.local', $user->email);
        $this->assertSame('other-sub', $other->fresh()->kuartal_id);
    }

    public function test_unverified_unlinked_local_account_with_same_email_is_not_linked(): void
    {
        $local = User::factory()->create(['email' => 'person@example.com', 'kuartal_id' => null, 'email_verified_at' => null]);
        $this->fakeKuartalId();

        $this->kuartalCallback()->assertRedirect(route('login'))->assertSessionHas('kuartal_id_error');

        $this->assertGuest();
        $this->assertNull($local->fresh()->kuartal_id);
    }

    public function test_verified_unlinked_local_account_with_same_verified_email_is_linked(): void
    {
        $local = User::factory()->create(['email' => 'person@example.com', 'kuartal_id' => null]);
        $this->fakeKuartalId();

        $this->kuartalCallback()->assertRedirect(route('account'));

        $this->assertAuthenticatedAs($local);
        $this->assertSame('kuartal-sub-1', $local->fresh()->kuartal_id);
    }

    public function test_signed_in_local_user_can_connect_kuartal_id(): void
    {
        $local = User::factory()->create(['email' => 'me@example.com', 'kuartal_id' => null]);
        $this->fakeKuartalId();

        $this->actingAs($local)->kuartalCallback()->assertRedirect(route('account'));

        $this->assertAuthenticatedAs($local);
        $this->assertSame('kuartal-sub-1', $local->fresh()->kuartal_id);
        // Like careers, the verified Kuartal ID email becomes the account email when it is free.
        $this->assertSame('person@example.com', $local->fresh()->email);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_admin_accounts_do_not_get_a_remember_me_cookie(): void
    {
        User::factory()->admin()->create(['kuartal_id' => 'kuartal-sub-1', 'email' => 'person@example.com']);
        $this->fakeKuartalId();

        $response = $this->kuartalCallback();

        $response->assertCookieMissing(Auth::guard()->getRecallerName());
    }

    /** @return array<string, array{0: string}> */
    public static function openRedirectTargets(): array
    {
        return [
            'userinfo trick' => ['https://ecoexplore.example@evil.com/'],
            'suffix domain' => ['https://ecoexplore.example.evil.com/account'],
            'other host' => ['https://evil.com/'],
            'protocol relative' => ['//evil.com/'],
            'backslash' => ['/\\evil.com'],
            'javascript' => ['javascript:alert(1)'],
        ];
    }

    #[DataProvider('openRedirectTargets')]
    public function test_open_redirects_are_blocked(string $target): void
    {
        config(['app.url' => 'https://ecoexplore.example']);

        $this->get('/auth/kuartal-id/redirect?redirect='.urlencode($target));
        $this->assertNull(session('kuartal_id.intended'));

        $this->fakeKuartalId();
        $this->kuartalCallback(['kuartal_id.intended' => $target])->assertRedirect(route('account'));
    }

    public function test_same_origin_targets_are_kept(): void
    {
        config(['app.url' => 'https://ecoexplore.example']);

        $this->get('/auth/kuartal-id/redirect?redirect='.urlencode('https://ecoexplore.example/book/journey/rinjani-responsible-trek'));
        $this->assertSame('/book/journey/rinjani-responsible-trek', session('kuartal_id.intended'));

        $this->fakeKuartalId();
        $this->kuartalCallback(['kuartal_id.intended' => '/explore'])->assertRedirect('/explore');
    }

    public function test_logout_after_kuartal_id_sign_in_ends_the_kuartal_id_session_too(): void
    {
        $this->fakeKuartalId();
        $this->kuartalCallback();

        $location = $this->post('/logout')->assertRedirect()->headers->get('Location');

        $this->assertGuest();
        $this->assertStringStartsWith(self::BASE, $location);
    }
}
