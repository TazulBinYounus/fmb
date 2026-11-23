<?php

use App\Models\Setting;

if (! function_exists('media_url')) {
    /**
     * Public URL for a stored image/file path.
     * "assets/…" = theme file in public/assets, anything else = admin upload in public/uploads.
     */
    function media_url(?string $path, ?string $fallback = null): ?string
    {
        if (! $path) {
            return $fallback ? asset($fallback) : null;
        }
        if (preg_match('#^https?://#', $path)) {
            return $path;
        }

        return str_starts_with($path, 'assets/') ? asset($path) : asset('uploads/'.$path);
    }
}

if (! function_exists('setting')) {
    /** Site setting from the admin panel. Pass a key ending without _bn; Bangla is used automatically if set. */
    function setting(string $key, mixed $default = null, bool $translated = false): mixed
    {
        return Setting::get($key, $default, $translated);
    }
}

if (! function_exists('bdt')) {
    /** Formats an amount in Bangladeshi Taka with lakh/crore grouping, e.g. ৳ 1,25,00,000. */
    function bdt(float|int|string|null $amount): ?string
    {
        if ($amount === null || $amount === '') {
            return null;
        }
        $amount = (string) (int) round((float) $amount);
        $last3 = substr($amount, -3);
        $rest = substr($amount, 0, -3);
        if ($rest !== '') {
            $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
            $last3 = $rest.','.$last3;
        }

        return '৳ '.$last3;
    }
}
