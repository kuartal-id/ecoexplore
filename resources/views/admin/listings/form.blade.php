@extends('layouts.app')
@php
    $l = $listing;
    $features = collect((array) ($l->features ?? []))->map(fn ($list) => implode("\n", (array) $list))->all();
@endphp
@section('title', $l->exists ? $l->name : __('ui.admin.new'))
@section('body_class', 'admin')
@section('content')
<section class="section admin-wrap">
    <div class="eyebrow">{{ __('ui.admin.title') }} · {{ __('ui.admin.listings') }}</div>
    <h1 class="admin-h1">{{ $l->exists ? $l->name : __('ui.admin.new') }}</h1>
    @include('admin.nav')
    @if ($errors->any())<div class="flash flash-err">{{ __('ui.checkout.fix_errors') }}</div>@endif
    <form method="post" action="{{ $l->exists ? route('admin.listings.update', $l) : route('admin.listings.store') }}" class="admin-form">
        @csrf
        @if ($l->exists) @method('put') @endif
        <div class="form-grid">
            <label class="field">{{ __('ui.admin.type') }}<select name="type">@foreach (\App\Models\Listing::TYPES as $t => $seg)<option value="{{ $t }}" @selected(old('type', $l->type) === $t)>{{ __('ui.directory.types.'.$t) }}</option>@endforeach</select></label>
            <label class="field">Subtype<input name="subtype" value="{{ old('subtype', $l->subtype) }}" placeholder="car_driver, flight_concierge, trek_organiser…">@error('subtype')<em class="err">{{ $message }}</em>@enderror</label>
            <label class="field">Slug<input name="slug" value="{{ old('slug', $l->slug) }}" required>@error('slug')<em class="err">{{ $message }}</em>@enderror</label>
            <label class="field">{{ __('ui.admin.name') }}<input name="name" value="{{ old('name', $l->name) }}" required>@error('name')<em class="err">{{ $message }}</em>@enderror</label>
            <label class="field">{{ __('ui.admin.location') }}<input name="location" value="{{ old('location', $l->location) }}" required>@error('location')<em class="err">{{ $message }}</em>@enderror</label>
            <label class="field">{{ __('ui.admin.price') }} (IDR)<input type="number" name="price_idr" value="{{ old('price_idr', $l->price_idr) }}" min="0"></label>
            <label class="field">{{ __('ui.admin.unit') }}<select name="price_unit"><option value="">—</option>@foreach (\App\Models\Listing::PRICE_UNITS as $u)<option value="{{ $u }}" @selected(old('price_unit', $l->price_unit) === $u)>{{ __('ui.unit.'.$u) }}</option>@endforeach</select></label>
            <label class="field">{{ __('ui.admin.image') }}<input name="image" value="{{ old('image', $l->image) }}" placeholder="assets/img/stay.svg"></label>
            <label class="field">{{ __('ui.admin.sort') }}<input type="number" name="sort_order" value="{{ old('sort_order', $l->sort_order) }}" min="0"></label>
        </div>
        @include('admin.pair', ['name' => 'summary', 'label' => __('ui.admin.summary'), 'value' => $l->summary, 'area' => true, 'rows' => 3])
        @include('admin.pair', ['name' => 'description', 'label' => __('ui.admin.description'), 'value' => $l->description, 'area' => true, 'rows' => 5])
        <p class="muted small">{{ __('ui.admin.lines_help') }}</p>
        @include('admin.pair', ['name' => 'features', 'label' => __('ui.admin.features'), 'value' => $features, 'area' => true, 'rows' => 4])
        <label class="check"><input type="checkbox" name="is_bookable" value="1" @checked(old('is_bookable', $l->is_bookable))> {{ __('ui.admin.bookable') }}</label>
        <label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $l->is_published))> {{ __('ui.admin.published') }}</label>
        <div class="hero-actions"><button class="btn btn-primary" type="submit">{{ __('ui.admin.save') }}</button></div>
    </form>
    @if ($l->exists)
        <form method="post" action="{{ route('admin.listings.destroy', $l) }}" class="top-gap">
            @csrf @method('delete')
            <button class="btn btn-ghost small danger" type="submit" onclick="return confirm('{{ __('ui.admin.delete_confirm') }}')">{{ __('ui.admin.delete') }}</button>
        </form>
    @endif
</section>
@endsection
