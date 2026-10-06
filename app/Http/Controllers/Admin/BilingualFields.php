<?php

namespace App\Http\Controllers\Admin;

/** Helpers to turn the bilingual admin form fields into translatable JSON values. */
trait BilingualFields
{
    /** @param  array<string, mixed>  $data */
    protected function pair(array $data, string $field): ?array
    {
        $value = array_filter([
            'id' => trim((string) ($data[$field.'_id'] ?? '')),
            'en' => trim((string) ($data[$field.'_en'] ?? '')),
        ], fn ($v) => $v !== '');

        return $value ?: null;
    }

    /** One item per line. */
    protected function lines(array $data, string $field): ?array
    {
        $out = [];
        foreach (['id', 'en'] as $locale) {
            $items = array_values(array_filter(array_map('trim', preg_split('/\R/', (string) ($data["{$field}_{$locale}"] ?? '')))));
            if ($items) {
                $out[$locale] = $items;
            }
        }

        return $out ?: null;
    }

    /** Itinerary: blocks separated by a blank line; first line of a block is the title. */
    protected function itinerary(array $data): ?array
    {
        $out = [];
        foreach (['id', 'en'] as $locale) {
            $blocks = preg_split('/\R\s*\R/', trim((string) ($data["itinerary_{$locale}"] ?? '')));
            $days = [];
            foreach ($blocks as $block) {
                $rows = preg_split('/\R/', trim($block), 2);
                if (trim($rows[0] ?? '') !== '') {
                    $days[] = ['title' => trim($rows[0]), 'body' => trim($rows[1] ?? '')];
                }
            }
            if ($days) {
                $out[$locale] = $days;
            }
        }

        return $out ?: null;
    }

    public static function itineraryText(?array $days): string
    {
        return collect($days ?? [])->map(fn ($d) => trim(($d['title'] ?? '')."\n".($d['body'] ?? '')))->implode("\n\n");
    }
}
