<?php

use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [SetLocale::class]);
        $middleware->encryptCookies(except: ['locale', 'theme']);
        $middleware->alias(['admin' => EnsureIsAdmin::class]);
        $middleware->redirectGuestsTo(fn () => route('login'));
        // Hostinger (LiteSpeed) terminates TLS in front of PHP.
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
