<div class="locale-switch" role="group" aria-label="{{ __('ui.nav.language') }}">
    @foreach (config('app.supported_locales') as $code)
        <a href="{{ route('locale', $code) }}" @class(['on' => app()->getLocale() === $code]) hreflang="{{ $code }}" lang="{{ $code }}">{{ strtoupper($code) }}</a>
    @endforeach
</div>
