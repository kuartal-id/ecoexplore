@extends('layouts.app')

@section('title', __('ui.auth.login_title'))

@section('content')
<section class="auth-wrap">
    <div class="auth-card">
        <div class="eyebrow">{{ __('ui.auth.eyebrow') }}</div>
        <h1>{{ __('ui.auth.login_title') }}</h1>
        <p class="muted">{{ __('ui.auth.login_lead') }}</p>
        @include('auth.kuartal-button')
        <form method="post" action="{{ route('login') }}" class="stack">
            @csrf
            <label class="field">{{ __('ui.checkout.email') }}<input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"></label>
            @error('email')<em class="err">{{ $message }}</em>@enderror
            <label class="field">{{ __('ui.auth.password') }}<input type="password" name="password" required autocomplete="current-password"></label>
            @error('password')<em class="err">{{ $message }}</em>@enderror
            <label class="check"><input type="checkbox" name="remember" value="1"> {{ __('ui.auth.remember') }}</label>
            <button class="btn btn-primary full" type="submit">{{ __('ui.auth.login_button') }}</button>
        </form>
        <p class="auth-links">
            <a class="link" href="{{ route('password.request') }}">{{ __('ui.auth.forgot') }}</a>
            <span>·</span>
            <a class="link" href="{{ route('register') }}">{{ __('ui.auth.no_account') }}</a>
        </p>
    </div>
</section>
@endsection
