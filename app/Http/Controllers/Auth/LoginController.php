<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\KuartalId\KuartalIdClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/** Local email/password login (kept alongside Kuartal ID, per Kuartal policy). */
class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $key = Str::lower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => __('auth.throttle', ['seconds' => RateLimiter::availableIn($key), 'minutes' => ceil(RateLimiter::availableIn($key) / 60)]),
            ]);
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();
        $request->session()->put('auth.via', 'local');

        return redirect()->intended(route('account'));
    }

    public function destroy(Request $request, KuartalIdClient $kuartalId): RedirectResponse
    {
        $viaKuartalId = $request->session()->get('auth.via') === 'kuartal_id';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Signed in with Kuartal ID: also end the Kuartal ID session (RP-initiated logout),
        // otherwise the next "Masuk dengan Kuartal ID" silently picks the same account.
        if ($viaKuartalId && $kuartalId->clientId() !== '') {
            return redirect()->away($kuartalId->endSessionUrl(route('home')));
        }

        return redirect()->route('home');
    }
}
