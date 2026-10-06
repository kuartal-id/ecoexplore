<?php

if (! function_exists('idr')) {
    /** Format whole rupiah: idr(1250000) => "Rp 1.250.000". */
    function idr(int|float|null $amount): string
    {
        return 'Rp '.number_format((float) $amount, 0, ',', '.');
    }
}

if (! function_exists('asset_v')) {
    /** Public asset URL with a cache-busting ?v= from the file's mtime. */
    function asset_v(string $path): string
    {
        $file = public_path($path);

        return asset($path).(is_file($file) ? '?v='.filemtime($file) : '');
    }
}

if (! function_exists('num')) {
    /** Locale-aware integer formatting: 1.150 (id) / 1,150 (en). */
    function num(int|float|string|null $value): string
    {
        return app()->getLocale() === 'en'
            ? number_format((float) $value, 0, '.', ',')
            : number_format((float) $value, 0, ',', '.');
    }
}
