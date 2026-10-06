<?php

namespace App\Models\Concerns;

/**
 * Content columns listed in $translatable are JSON objects keyed by locale:
 * {"id": "Teks Indonesia", "en": "English text"}. tr() returns the current
 * locale's value, falling back to the app fallback locale, then any value.
 */
trait HasTranslations
{
    public function initializeHasTranslations(): void
    {
        foreach ($this->translatable ?? [] as $field) {
            $this->mergeCasts([$field => 'array']);
        }
    }

    public function tr(string $field, ?string $locale = null): mixed
    {
        $value = $this->getAttribute($field);

        if (! is_array($value)) {
            return $value ?? '';
        }

        $locale ??= app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        foreach ([$locale, $fallback, 'en', 'id'] as $key) {
            if (array_key_exists($key, $value) && $value[$key] !== null && $value[$key] !== '' && $value[$key] !== []) {
                return $value[$key];
            }
        }

        return reset($value) ?: '';
    }

    /** Lists (itinerary, includes...) always come back as an array. */
    public function trList(string $field, ?string $locale = null): array
    {
        $value = $this->tr($field, $locale);

        return is_array($value) ? array_values($value) : [];
    }
}
