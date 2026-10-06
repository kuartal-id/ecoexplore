<?php

namespace App\Http\Controllers;

use App\Support\SafeRedirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, config('app.supported_locales', ['id', 'en']), true)) {
            abort(404);
        }

        $request->session()->put('locale', $locale);

        if ($user = $request->user()) {
            $user->forceFill(['locale' => $locale])->save();
        }

        $back = SafeRedirect::sanitize($request->query('redirect', $request->headers->get('referer')));

        return redirect()->to($back ?: route('home'))
            ->withCookie(cookie()->forever('locale', $locale, httpOnly: false));
    }
}
