{{-- Bilingual field: $name, $label, $value (array id/en or string per locale), $area (bool), $rows --}}
<div class="pair">
    @foreach (['id' => 'Bahasa Indonesia', 'en' => 'English'] as $loc => $locName)
        <label class="field">{{ $label }} <small class="muted">({{ $locName }})</small>
            @if (! empty($area))
                <textarea name="{{ $name }}_{{ $loc }}" rows="{{ $rows ?? 4 }}">{{ old($name.'_'.$loc, $value[$loc] ?? '') }}</textarea>
            @else
                <input type="text" name="{{ $name }}_{{ $loc }}" value="{{ old($name.'_'.$loc, $value[$loc] ?? '') }}">
            @endif
            @error($name.'_'.$loc)<em class="err">{{ $message }}</em>@enderror
        </label>
    @endforeach
</div>
