@extends('layouts.app')

@section('title', __('ui.auth.forgot'))

@section('content')
<section class="auth-wrap">
    <div class="auth-card">
        <h1>{{ __('ui.auth.forgot') }}</h1>
        <p class="muted">{{ __('ui.auth.forgot_lead') }}</p>
        <form method="post" action="{{ route('password.email') }}" class="stack">
            @csrf
            <label class="field">{{ __('ui.checkout.email') }}<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></label>
            @error('email')<em class="err">{{ $message }}</em>@enderror
            <button class="btn btn-primary full" type="submit">{{ __('ui.auth.send_link') }}</button>
        </form>
        <p class="auth-links"><a class="link" href="{{ route('login') }}">← {{ __('ui.auth.login_title') }}</a></p>
    </div>
</section>
@endsection
