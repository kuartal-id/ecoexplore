@extends('layouts.app')

@section('title', __('ui.auth.register_title'))

@section('content')
<section class="auth-wrap">
    <div class="auth-card">
        <div class="eyebrow">{{ __('ui.auth.eyebrow') }}</div>
        <h1>{{ __('ui.auth.register_title') }}</h1>
        <p class="muted">{{ __('ui.auth.register_lead') }}</p>
        @include('auth.kuartal-button')
        <form method="post" action="{{ route('register') }}" class="stack">
            @csrf
            <label class="field">{{ __('ui.checkout.name') }}<input type="text" name="name" value="{{ old('name') }}" required autocomplete="name"></label>
            @error('name')<em class="err">{{ $message }}</em>@enderror
            <label class="field">{{ __('ui.checkout.email') }}<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></label>
            @error('email')<em class="err">{{ $message }}</em>@enderror
            <label class="field">{{ __('ui.checkout.phone') }} <small class="muted">({{ __('ui.common.optional') }})</small><input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel"></label>
            @error('phone')<em class="err">{{ $message }}</em>@enderror
            <label class="field">{{ __('ui.auth.password') }}<input type="password" name="password" required autocomplete="new-password"></label>
            @error('password')<em class="err">{{ $message }}</em>@enderror
            <label class="field">{{ __('ui.auth.password_confirm') }}<input type="password" name="password_confirmation" required autocomplete="new-password"></label>
            <button class="btn btn-primary full" type="submit">{{ __('ui.auth.register_button') }}</button>
        </form>
        <p class="auth-links"><a class="link" href="{{ route('login') }}">{{ __('ui.auth.have_account') }}</a></p>
    </div>
</section>
@endsection
