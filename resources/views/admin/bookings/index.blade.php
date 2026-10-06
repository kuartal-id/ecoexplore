@extends('layouts.app')
@section('title', __('ui.admin.bookings'))
@section('body_class', 'admin')
@section('content')
<section class="section admin-wrap">
    <div class="eyebrow">{{ __('ui.admin.title') }}</div>
    <h1 class="admin-h1">{{ __('ui.admin.bookings') }}</h1>
    @include('admin.nav')
    <form class="admin-filter" method="get">
        <input type="search" name="q" value="{{ $q }}" placeholder="{{ __('ui.admin.search') }}">
        <select name="payment_status">
            <option value="">{{ __('ui.common.all') }}</option>
            @foreach (['pending', 'paid', 'failed', 'expired'] as $s)<option value="{{ $s }}" @selected($status === $s)>{{ __('ui.payment_status.'.$s) }}</option>@endforeach
        </select>
        <button class="btn btn-ghost small" type="submit">{{ __('ui.common.search') }}</button>
    </form>
    @include('admin.bookings.table')
    <div class="pager">
        @if ($bookings->previousPageUrl())<a class="btn btn-ghost small" href="{{ $bookings->previousPageUrl() }}">←</a>@endif
        <span class="muted">{{ $bookings->currentPage() }} / {{ $bookings->lastPage() }}</span>
        @if ($bookings->nextPageUrl())<a class="btn btn-ghost small" href="{{ $bookings->nextPageUrl() }}">→</a>@endif
    </div>
</section>
@endsection
