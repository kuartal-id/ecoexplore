@extends('layouts.app')
@section('title', __('ui.admin.listings'))
@section('body_class', 'admin')
@section('content')
<section class="section admin-wrap">
    <div class="eyebrow">{{ __('ui.admin.title') }}</div>
    <h1 class="admin-h1">{{ __('ui.admin.listings') }}</h1>
    @include('admin.nav')
    <div class="filter-row">
        <a href="{{ route('admin.listings.index') }}" @class(['pill', 'on' => ! $type])>{{ __('ui.common.all') }}</a>
        @foreach (\App\Models\Listing::TYPES as $t => $seg)
            <a href="{{ route('admin.listings.index', ['type' => $t]) }}" @class(['pill', 'on' => $type === $t])>{{ __('ui.directory.types.'.$t) }}</a>
        @endforeach
    </div>
    <p><a class="btn btn-primary small" href="{{ route('admin.listings.create') }}">+ {{ __('ui.admin.new') }}</a></p>
    <div class="table-wrap"><table class="table">
        <thead><tr><th>{{ __('ui.admin.name') }}</th><th>{{ __('ui.admin.type') }}</th><th>{{ __('ui.admin.price') }}</th><th>{{ __('ui.admin.bookable') }}</th><th>{{ __('ui.admin.published') }}</th><th></th></tr></thead>
        <tbody>
        @foreach ($listings as $l)
            <tr>
                <td><b>{{ $l->name }}</b><br><small class="muted">{{ $l->slug }}</small></td>
                <td>{{ __('ui.directory.types.'.$l->type) }}<br><small class="muted">{{ $l->subtype }}</small></td>
                <td>{{ $l->price_idr ? idr($l->price_idr).' / '.__('ui.unit.'.$l->price_unit) : '—' }}</td>
                <td>{{ $l->is_bookable ? '✓' : '—' }}</td>
                <td>{{ $l->is_published ? '✓' : '—' }}</td>
                <td><a class="link" href="{{ route('admin.listings.edit', $l) }}">{{ __('ui.admin.edit') }}</a> · <a class="link" href="{{ route('directory.show', [$l->segment(), $l->slug]) }}">{{ __('ui.admin.view') }}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table></div>
</section>
@endsection
