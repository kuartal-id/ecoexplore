<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/** Local email/password accounts, kept alongside Kuartal ID. */
class LocalAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_offers_both_local_and_kuartal_id_sign_in(): void
    {
        $this->get('/login')->assertOk()
            ->assertSee('name="password"', false)
            ->assertSee(route('login.kuartal-id'), false);
    }

    public function test_registration_creates_a_normal_account(): void
    {
        $this->post('/register', [
            'name' => 'Ayu', 'email' => 'ayu@example.com', 'phone' => '0812',
            'password' => 'secret-pass-1', 'password_confirmation' => 'secret-pass-1',
            'is_admin' => '1',
        ])->assertRedirect(route('account'));

        $user = User::where('email', 'ayu@example.com')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertFalse($user->is_admin, 'is_admin must not be mass assignable.');
        $this->assertTrue(Hash::check('secret-pass-1', $user->password));
        $this->assertSame('id', $user->locale);
    }

    public function test_registration_validation(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->post('/register', ['name' => '', 'email' => 'taken@example.com', 'password' => 'short', 'password_confirmation' => 'other'])
            ->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest();
    }

    public function test_login_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'correct-horse']);

        $this->post('/login', ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post('/login', ['email' => $user->email, 'password' => 'correct-horse'])->assertRedirect(route('account'));
        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_login_is_rate_limited(): void
    {
        $user = User::factory()->create(['password' => 'correct-horse']);

        foreach (range(1, 5) as $i) {
            $this->post('/login', ['email' => $user->email, 'password' => 'wrong']);
        }

        $this->post('/login', ['email' => $user->email, 'password' => 'correct-horse'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_returns_to_the_intended_page(): void
    {
        $user = User::factory()->create(['password' => 'correct-horse']);

        $this->get('/account')->assertRedirect(route('login'));
        $this->post('/login', ['email' => $user->email, 'password' => 'correct-horse'])->assertRedirect(route('account'));
    }

    public function test_password_reset(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email])->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $this->get('/reset-password/'.$notification->token.'?email='.urlencode($user->email))->assertOk();
            $this->post('/reset-password', [
                'token' => $notification->token, 'email' => $user->email,
                'password' => 'brand-new-pass', 'password_confirmation' => 'brand-new-pass',
            ])->assertRedirect(route('login'));

            return true;
        });

        $this->assertTrue(Hash::check('brand-new-pass', $user->fresh()->password));
    }

    public function test_forgot_password_does_not_reveal_unknown_emails(): void
    {
        Notification::fake();

        $this->post('/forgot-password', ['email' => 'nobody@example.com'])->assertSessionHas('status')->assertSessionHasNoErrors();
    }

    public function test_signed_in_users_cannot_see_guest_pages(): void
    {
        $this->actingAs(User::factory()->create())->get('/login')->assertRedirect();
    }
}
