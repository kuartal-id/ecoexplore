@extends('layouts.app')
@section('title', __('ui.admin.title'))
@section('body_class', 'admin')
@section('content')
<section class="section admin-wrap">
    <div class="eyebrow">{{ __('ui.admin.title') }}</div>
    <h1 class="admin-h1">{{ __('ui.admin.dashboard') }}</h1>
    @include('admin.nav')
    <div class="admin-stats">
        <div><span>{{ __('ui.admin.stat_pending') }}</span><b>{{ $stats['pending'] }}</b></div>
        <div><span>{{ __('ui.admin.stat_confirmed') }}</span><b>{{ $stats['confirmed'] }}</b></div>
        <div><span>{{ __('ui.admin.stat_paid') }}</span><b>{{ idr($stats['paid_idr']) }}</b></div>
        <div><span>{{ __('ui.admin.journeys') }} / {{ __('ui.admin.listings') }} / {{ __('ui.admin.projects') }}</span><b>{{ $stats['journeys'] }} / {{ $stats['listings'] }} / {{ $stats['projects'] }}</b></div>
    </div>
    <h2 class="block-title">{{ __('ui.admin.recent') }}</h2>
    @include('admin.bookings.table', ['bookings' => $recent])
</section>
@endsection
