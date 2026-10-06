<footer class="footer">
    <div class="footer-brand">
        <strong>Ecoexplore</strong>
        <span>{{ __('ui.footer.tagline') }}</span>
        <span>© {{ date('Y') }} {{ config('ecoexplore.legal_entity') ?: 'Ecoexplore · Kuartal' }}</span>
    </div>
    <div class="footer-links">
        <a href="{{ route('about') }}">{{ __('ui.footer.about') }}</a>
        <a href="{{ route('terms') }}">{{ __('ui.footer.terms') }}</a>
        <a href="{{ route('privacy') }}">{{ __('ui.footer.privacy') }}</a>
        @if (config('ecoexplore.contact_email'))
            <a href="mailto:{{ config('ecoexplore.contact_email') }}">{{ config('ecoexplore.contact_email') }}</a>
        @endif
        @if (config('ecoexplore.whatsapp'))
            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('ecoexplore.whatsapp')) }}" rel="noopener">WhatsApp</a>
        @endif
    </div>
    <p class="footer-note">{{ __('ui.footer.sample_note') }}</p>
</footer>
