<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')@yield('title') · @endif{{ config('app.name', 'Ecoexplore') }}</title>
    <meta name="description" content="@yield('description', __('ui.meta.description'))">
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', __('ui.meta.description'))">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#f6f1e2" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#083335" media="(prefers-color-scheme: dark)">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icons/favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/icons/apple-touch-icon.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Ecoexplore">
    <link rel="stylesheet" href="{{ asset_v('assets/app.css') }}">
    {{-- Theme before first paint: saved choice, else the OS preference. --}}
    <script>(function(){try{var t=localStorage.getItem('eco-theme');if(t!=='light'&&t!=='dark'){t=window.matchMedia&&matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light'}if(t==='dark'){document.documentElement.classList.add('dark')}}catch(e){}})();</script>
</head>
<body class="@yield('body_class')">
    <a class="skip-link" href="#main">{{ __('ui.nav.skip') }}</a>
    @include('partials.sidebar')
    @include('partials.header')

    <main id="main" class="page">
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.mobile-nav')
    <script src="{{ asset_v('assets/app.js') }}" defer></script>
</body>
</html>
