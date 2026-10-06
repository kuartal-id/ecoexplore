@extends('layouts.app')

@section('title', __('ui.offline.title'))

@section('content')
<section class="confirmation">
    <div class="success-icon"><x-icon name="cloud" size="30"/></div>
    <h1>{{ __('ui.offline.title') }}</h1>
    <p>{{ __('ui.offline.text') }}</p>
    <div class="hero-actions center"><a class="btn btn-primary" href="{{ route('home') }}">{{ __('ui.offline.retry') }}</a></div>
</section>
@endsection
