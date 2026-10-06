<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\KuartalId\IdTokenVerifier;
use App\Support\KuartalId\KuartalIdClient;
use App\Support\KuartalId\KuartalIdException;
use App\Support\SafeRedirect;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * "Masuk dengan Kuartal ID" -- the OAuth2/OIDC authorization code flow with PKCE (S256),
 * state and nonce against id.kuartal.id (kuartal-login, Laravel Passport). Ported from
 * kuartal-id/careers. Unlike careers, Ecoexplore ALSO keeps its own email/password login
 * (Kuartal policy: every site keeps a local login plus Kuartal ID).
 *
 * Accounts are matched by users.kuartal_id (= Kuartal ID `sub`). A signed-in local account
 * can connect Kuartal ID by starting this flow while logged in.
 *
 * Checks on the way back (callback()): state (CSRF), PKCE verifier, a verified id_token
 * (RS256 via JWKS, iss, aud, exp/iat, nonce -- IdTokenVerifier), id_token sub == userinfo
 * sub, and a same-origin-only post-login redirect (SafeRedirect).
 */
class KuartalIdLoginController extends Controller
{
    public function __construct(
        private KuartalIdClient $kuartalId,
        private IdTokenVerifier $idTokens,
    ) {}

    public function redirect(Request $request): RedirectResponse
    {
        if ($this->kuartalId->clientId() === '' || ! config('services.kuartal_id.redirect')) {
            return redirect()->route('login')->with('kuartal_id_error', __('ui.auth.kuartal_unavailable'));
        }

        $state = Str::random(40);
        $nonce = Str::random(40);
        $verifier = Str::random(64);
        $challenge = rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');

        $request->session()->put('kuartal_id.state', $state);
        $request->session()->put('kuartal_id.nonce', $nonce);
        $request->session()->put('kuartal_id.verifier', $verifier);
        $request->session()->put('kuartal_id.intended', SafeRedirect::sanitize(
            $request->query('redirect', $request->session()->get('url.intended'))
        ));

        return redirect($this->kuartalId->authorizeUrl($state, $challenge, $nonce));
    }

    public function callback(Request $request): RedirectResponse
    {
        if ($request->filled('error')) {
            return $this->fail(__('ui.auth.kuartal_cancelled'));
        }

        $state = $request->session()->pull('kuartal_id.state');
        $nonce = $request->session()->pull('kuartal_id.nonce');
        $verifier = $request->session()->pull('kuartal_id.verifier');
        $intended = SafeRedirect::sanitize($request->session()->pull('kuartal_id.intended'));

        if (! is_string($state) || ! is_string($request->query('state'))
            || ! hash_equals($state, $request->query('state')) || ! $request->filled('code')
            || ! is_string($verifier) || ! is_string($nonce)) {
            return $this->fail(__('ui.auth.kuartal_failed'));
        }

        try {
            $tokens = $this->kuartalId->exchangeCode((string) $request->query('code'), $verifier, $nonce);
            $idClaims = $this->idTokens->verify($tokens['id_token'] ?? null, $nonce);
            $claims = $this->kuartalId->userInfo($tokens['access_token']);

            if ($claims['sub'] !== $idClaims['sub']) {
                throw KuartalIdException::invalid('userinfo sub does not match id_token sub');
            }
        } catch (KuartalIdException $e) {
            report($e);

            return $this->fail(__('ui.auth.kuartal_failed'));
        }

        $user = $this->resolveUser($claims, $request->user());

        if (is_string($user)) {
            return $this->fail($user);
        }

        $user->avatar_url = is_string($claims['picture'] ?? null) ? $claims['picture'] : $user->avatar_url;

        try {
            $user->save();
        } catch (UniqueConstraintViolationException $e) {
            report($e);

            return $this->fail(__('ui.auth.kuartal_failed'));
        }

        // No long-lived remember-me cookie for admin accounts (same idea as careers' HR).
        Auth::login($user, remember: ! $user->isAdmin());
        $request->session()->regenerate();
        $request->session()->put('auth.via', 'kuartal_id');

        return redirect()->to($intended ?: route('account'));
    }

    /**
     * Find or create the local account for these (verified) claims without ever 500ing on
     * the unique `email` column. Same rules as careers, plus: a signed-in local account
     * without a Kuartal ID is linked to it (explicit "connect Kuartal ID").
     *
     * @param  array<string, mixed>  $claims
     */
    private function resolveUser(array $claims, ?User $current): User|string
    {
        $sub = $claims['sub'];
        $email = is_string($claims['email'] ?? null) && $claims['email'] !== '' ? $claims['email'] : null;
        $emailVerified = ($claims['email_verified'] ?? false) === true;

        $user = User::where('kuartal_id', $sub)->first();

        if (! $user && $current && $current->kuartal_id === null) {
            $user = $current; // Connecting Kuartal ID to the account that is signed in.
        }

        $holder = $email ? User::where('email', $email)->first() : null;

        if (! $user && $holder) {
            if ($holder->kuartal_id === null) {
                if (! $emailVerified || ! $holder->email_verified_at) {
                    Log::warning('Kuartal ID sign-in refused: email belongs to an unlinked local account that is not verified on both sides.', [
                        'local_user_id' => $holder->id,
                    ]);

                    return __('ui.auth.kuartal_link_required');
                }

                $user = $holder;
            } else {
                Log::warning('Kuartal ID sign-in: email already used by another Kuartal ID account; using a placeholder email.', [
                    'other_user_id' => $holder->id,
                ]);
                $email = null;
            }
        }

        $user ??= new User;

        if ($email && $holder && $holder->isNot($user)) {
            Log::warning('Kuartal ID sign-in: email already used by another account; keeping the existing email.', [
                'user_id' => $user->id,
                'other_user_id' => $holder->id,
            ]);
            $email = null;
        }

        $user->kuartal_id = $sub;
        $user->name = (is_string($claims['name'] ?? null) && $claims['name'] !== '' ? $claims['name'] : null) ?? $user->name ?? 'Kuartal ID member';
        $newEmail = $email ?? $user->email ?? $sub.'@kuartal-id.local';
        if ($newEmail !== $user->email) {
            $user->email = $newEmail;
            $user->email_verified_at = $email && $emailVerified ? now() : null;
        } elseif ($email && $emailVerified) {
            $user->email_verified_at ??= now();
        }
        if (! $user->exists) {
            // Kuartal ID users sign in through Kuartal ID; a random, never-communicated hash
            // satisfies the NOT NULL column. They can set a local password via "forgot password".
            $user->password = Hash::make(Str::random(40));
        }

        return $user;
    }

    private function fail(string $message): RedirectResponse
    {
        // A signed-in user who was connecting Kuartal ID goes back to their account page
        // (the guest-only login page would bounce them and lose the message).
        return redirect()->route(Auth::check() ? 'account' : 'login')->with('kuartal_id_error', $message);
    }
}
