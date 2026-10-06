@extends('layouts.app')
@php
    $j = $journey;
    $lines = fn ($v) => collect((array) ($v ?? []))->map(fn ($list) => implode("\n", (array) $list))->all();
    $itin = collect((array) ($j->itinerary ?? []))->map(fn ($days) => \App\Http\Controllers\Admin\BilingualFields::itineraryText((array) $days))->all();
@endphp
@section('title', $j->exists ? $j->tr('title') : __('ui.admin.new'))
@section('body_class', 'admin')
@section('content')
<section class="section admin-wrap">
    <div class="eyebrow">{{ __('ui.admin.title') }} · {{ __('ui.admin.journeys') }}</div>
    <h1 class="admin-h1">{{ $j->exists ? $j->tr('title') : __('ui.admin.new') }}</h1>
    @include('admin.nav')
    @if ($errors->any())<div class="flash flash-err">{{ __('ui.checkout.fix_errors') }}</div>@endif
    @if (session('status'))<div class="flash">{{ session('status') }}</div>@endif
    <form method="post" action="{{ $j->exists ? route('admin.journeys.update', $j) : route('admin.journeys.store') }}" class="admin-form">
        @csrf
        @if ($j->exists) @method('put') @endif
        <div class="form-grid">
            <label class="field">Slug<input name="slug" value="{{ old('slug', $j->slug) }}" required>@error('slug')<em class="err">{{ $message }}</em>@enderror</label>
            <label class="field">{{ __('ui.admin.category') }}<select name="category">@foreach (\App\Models\Journey::CATEGORIES as $c)<option value="{{ $c }}" @selected(old('category', $j->category) === $c)>{{ __('ui.category.'.$c) }}</option>@endforeach</select></label>
            <label class="field">{{ __('ui.admin.region') }}<input name="region" value="{{ old('region', $j->region) }}" required>@error('region')<em class="err">{{ $message }}</em>@enderror</label>
            <label class="field">{{ __('ui.admin.price') }} (IDR / {{ __('ui.unit.person') }})<input type="number" name="price_idr" value="{{ old('price_idr', $j->price_idr) }}" required min="0">@error('price_idr')<em class="err">{{ $message }}</em>@enderror</label>
            <label class="field">{{ __('ui.admin.days') }}<input type="number" name="duration_days" value="{{ old('duration_days', $j->duration_days) }}" min="1" required></label>
            <label class="field">{{ __('ui.admin.nights') }}<input type="number" name="duration_nights" value="{{ old('duration_nights', $j->duration_nights) }}" min="0" required></label>
            <label class="field">Min pax<input type="number" name="min_pax" value="{{ old('min_pax', $j->min_pax) }}" min="1" required></label>
            <label class="field">Max pax<input type="number" name="max_pax" value="{{ old('max_pax', $j->max_pax) }}" min="1" required>@error('max_pax')<em class="err">{{ $message }}</em>@enderror</label>
            <label class="field">{{ __('ui.admin.difficulty') }}<select name="difficulty">@foreach (['easy', 'moderate', 'challenging'] as $d)<option value="{{ $d }}" @selected(old('difficulty', $j->difficulty) === $d)>{{ __('ui.difficulty.'.$d) }}</option>@endforeach</select></label>
            <label class="field">{{ __('ui.admin.image') }}<input name="image" value="{{ old('image', $j->image) }}" placeholder="assets/img/photos/journey__rinjani-responsible-trek.jpg"></label>
            <label class="field">{{ __('ui.journey.partner') }}<input name="community_partner" value="{{ old('community_partner', $j->community_partner) }}"></label>
            <label class="field">{{ __('ui.admin.carbon') }}<input type="number" name="carbon_kg_pp" value="{{ old('carbon_kg_pp', $j->carbon_kg_pp) }}" min="0"></label>
            <label class="field">{{ __('ui.admin.sort') }}<input type="number" name="sort_order" value="{{ old('sort_order', $j->sort_order) }}" min="0"></label>
        </div>
        @include('admin.pair', ['name' => 'title', 'label' => __('ui.admin.name'), 'value' => $j->title])
        @include('admin.pair', ['name' => 'tagline', 'label' => 'Tagline', 'value' => $j->tagline])
        @include('admin.pair', ['name' => 'summary', 'label' => __('ui.admin.summary'), 'value' => $j->summary, 'area' => true, 'rows' => 3])
        @include('admin.pair', ['name' => 'description', 'label' => __('ui.admin.description'), 'value' => $j->description, 'area' => true, 'rows' => 6])
        <p class="muted small">{{ __('ui.admin.itinerary_help') }}</p>
        @include('admin.pair', ['name' => 'itinerary', 'label' => __('ui.journey.itinerary'), 'value' => $itin, 'area' => true, 'rows' => 10])
        <p class="muted small">{{ __('ui.admin.lines_help') }}</p>
        @include('admin.pair', ['name' => 'includes', 'label' => __('ui.journey.includes'), 'value' => $lines($j->includes), 'area' => true, 'rows' => 5])
        @include('admin.pair', ['name' => 'excludes', 'label' => __('ui.journey.excludes'), 'value' => $lines($j->excludes), 'area' => true, 'rows' => 3])
        @include('admin.pair', ['name' => 'impact', 'label' => __('ui.journey.impact'), 'value' => $j->impact, 'area' => true, 'rows' => 3])
        <label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $j->is_published))> {{ __('ui.admin.published') }}</label>
        <label class="check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $j->is_featured))> {{ __('ui.admin.featured') }}</label>
        <div class="hero-actions"><button class="btn btn-primary" type="submit">{{ __('ui.admin.save') }}</button></div>
    </form>
    @if ($j->exists)
        @include('admin.partials.image-upload', [
            'model' => $j,
            'upload' => route('admin.journeys.image', $j),
            'remove' => route('admin.journeys.image.remove', $j),
        ])
        <form method="post" action="{{ route('admin.journeys.destroy', $j) }}" class="top-gap">
            @csrf @method('delete')
            <button class="btn btn-ghost small danger" type="submit" onclick="return confirm('{{ __('ui.admin.delete_confirm') }}')">{{ __('ui.admin.delete') }}</button>
        </form>
    @endif
</section>
@endsection
