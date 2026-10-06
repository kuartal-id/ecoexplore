<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ImageUploader
{
    /**
     * Validate and store an uploaded image in public/assets/uploads/{dir}.
     * Returns the public-relative path to store on the model (e.g. journeys/...).
     * Resizes to max 1600px when GD is available, otherwise stores the original.
     */
    public static function handle(Request $request, string $field, string $dir): string
    {
        $file = $request->file($field);

        if (! $file || ! $file->isValid()) {
            throw ValidationException::withMessages([$field => __('ui.admin.image_invalid')]);
        }

        if ($file->getSize() > 8 * 1024 * 1024) {
            throw ValidationException::withMessages([$field => __('ui.admin.image_too_big')]);
        }

        // getimagesize() is PHP core — real image verification without GD.
        $info = @getimagesize($file->getRealPath());
        $allowed = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
        if (! $info || ! isset($allowed[$info[2]])) {
            throw ValidationException::withMessages([$field => __('ui.admin.image_invalid')]);
        }

        $targetDir = public_path('assets/uploads/'.$dir);
        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $name = date('Ym').'-'.Str::random(12).'.'.$allowed[$info[2]];
        $target = $targetDir.'/'.$name;

        if (! static::resizeWithGd($file->getRealPath(), $target, $info)) {
            $file->move($targetDir, $name);
        }

        return 'assets/uploads/'.$dir.'/'.$name;
    }

    /**
     * Downscale to max 1600px on the long edge using GD when the extension
     * is loaded. Returns false when GD is unavailable or resizing failed,
     * so the caller can fall back to storing the original file.
     */
    protected static function resizeWithGd(string $src, string $dest, array $info): bool
    {
        if (! extension_loaded('gd') || max($info[0], $info[1]) <= 1600) {
            return false;
        }

        try {
            $im = match ($info[2]) {
                IMAGETYPE_JPEG => imagecreatefromjpeg($src),
                IMAGETYPE_PNG => imagecreatefrompng($src),
                IMAGETYPE_WEBP => imagecreatefromwebp($src),
            };
            if (! $im) {
                return false;
            }

            $scale = 1600 / max($info[0], $info[1]);
            $w = max(1, (int) round($info[0] * $scale));
            $h = max(1, (int) round($info[1] * $scale));
            $out = imagescale($im, $w, $h);

            $ok = match ($info[2]) {
                IMAGETYPE_JPEG => imagejpeg($out, $dest, 82),
                IMAGETYPE_PNG => imagepng($out, $dest, 6),
                IMAGETYPE_WEBP => imagewebp($out, $dest, 82),
            };
            imagedestroy($im);
            imagedestroy($out);

            return (bool) $ok;
        } catch (\Throwable) {
            return false;
        }
    }
}
