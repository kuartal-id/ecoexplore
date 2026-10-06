<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Indonesian by default; English when chosen via /locale/en (session + cookie). */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = config('app.supported_locales', ['id', 'en']);
        $locale = $request->session()->get('locale')
            ?? $request->cookie('locale')
            ?? $request->user()?->locale
            ?? config('app.locale');

        app()->setLocale(in_array($locale, $supported, true) ? $locale : config('app.locale'));

        return $next($request);
    }
}
