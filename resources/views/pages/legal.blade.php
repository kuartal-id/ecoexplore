@extends('layouts.app')

@section('title', __('ui.legal.'.$page.'_title'))

@section('content')
<section class="subhero compact">
    <h1>{{ __('ui.legal.'.$page.'_title') }}</h1>
    <div class="sample-notice" role="note"><x-icon name="shield" size="16"/> <span>{{ __('ui.legal.draft_notice') }}</span></div>
</section>
<section class="section tight prose">
    @foreach (__('ui.legal.'.$page.'_sections') as $section)
        <h2>{{ $section['h'] }}</h2>
        <p>{{ $section['p'] }}</p>
    @endforeach
    <p class="muted">{{ __('ui.legal.entity', ['entity' => config('ecoexplore.legal_entity') ?: '[SUPPLY: legal entity]']) }}</p>
</section>
@endsection
