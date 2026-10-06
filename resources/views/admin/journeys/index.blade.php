@extends('layouts.app')
@section('title', __('ui.admin.journeys'))
@section('body_class', 'admin')
@section('content')
<section class="section admin-wrap">
    <div class="eyebrow">{{ __('ui.admin.title') }}</div>
    <h1 class="admin-h1">{{ __('ui.admin.journeys') }}</h1>
    @include('admin.nav')
    <p><a class="btn btn-primary small" href="{{ route('admin.journeys.create') }}">+ {{ __('ui.admin.new') }}</a></p>
    <div class="table-wrap"><table class="table">
        <thead><tr><th>#</th><th>{{ __('ui.admin.name') }}</th><th>{{ __('ui.admin.duration') }}</th><th>{{ __('ui.admin.price') }}</th><th>{{ __('ui.admin.published') }}</th><th></th></tr></thead>
        <tbody>
        @foreach ($journeys as $j)
            <tr>
                <td>{{ $j->sort_order }}</td>
                <td><b>{{ $j->tr('title') }}</b><br><small class="muted">{{ $j->slug }}</small></td>
                <td>{{ $j->durationLabel() }}</td>
                <td>{{ idr($j->price_idr) }}</td>
                <td>{{ $j->is_published ? '✓' : '—' }}</td>
                <td><a class="link" href="{{ route('admin.journeys.edit', $j) }}">{{ __('ui.admin.edit') }}</a> · <a class="link" href="{{ route('journeys.show', $j) }}">{{ __('ui.admin.view') }}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table></div>
</section>
@endsection
