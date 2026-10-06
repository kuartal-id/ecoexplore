@php
$dirIcons = ['accommodation' => 'bed', 'culinary' => 'utensils', 'attraction' => 'mountain', 'activity' => 'compass', 'eco_shop' => 'bag', 'transport' => 'car', 'guide' => 'users'];
@endphp
<div class="category-grid">
    @foreach (\App\Models\Listing::TYPES as $type => $segment)
        <a href="{{ route('directory.index', $segment) }}">
            <span><x-icon :name="$dirIcons[$type]" size="26"/></span>
            <b>{{ __('ui.directory.types.'.$type) }}</b>
            <small>{{ __('ui.directory.blurbs.'.$type) }}@isset($listingCounts[$type]) · {{ $listingCounts[$type] }}@endisset</small>
        </a>
    @endforeach
</div>
