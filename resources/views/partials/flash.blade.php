@foreach (['status' => 'ok', 'error' => 'err', 'kuartal_id_error' => 'err'] as $key => $tone)
    @if (session($key))
        <div class="flash flash-{{ $tone }}" role="status">{{ session($key) }}</div>
    @endif
@endforeach
