<a class="btn kuartal-btn full" href="{{ route('login.kuartal-id', array_filter(['redirect' => session('url.intended') ? parse_url(session('url.intended'), PHP_URL_PATH) : null])) }}">
    <x-icon name="shield" size="18"/> {{ __('ui.auth.kuartal_button') }}
</a>
<div class="divider"><span>{{ __('ui.auth.or') }}</span></div>
