@extends('layouts.app')

@section('title', __('ui.auth.reset_title'))

@section('content')
<section class="auth-wrap">
    <div class="auth-card">
        <h1>{{ __('ui.auth.reset_title') }}</h1>
        <form method="post" action="{{ route('password.update') }}" class="stack">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <label class="field">{{ __('ui.checkout.email') }}<input type="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email"></label>
            @error('email')<em class="err">{{ $message }}</em>@enderror
            <label class="field">{{ __('ui.auth.password') }}<input type="password" name="password" required autocomplete="new-password"></label>
            @error('password')<em class="err">{{ $message }}</em>@enderror
            <label class="field">{{ __('ui.auth.password_confirm') }}<input type="password" name="password_confirmation" required autocomplete="new-password"></label>
            <button class="btn btn-primary full" type="submit">{{ __('ui.auth.reset_button') }}</button>
        </form>
    </div>
</section>
@endsection
