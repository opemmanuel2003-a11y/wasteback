<?php

if (! function_exists('img')) {
    /**
     * URL of a local picture in public/images for an image key in config/site.php.
     * Small sizes use the 400px copy in images/thumbs; CSS object-fit does the cropping.
     * Unknown keys fall back to the bottles picture.
     */
    function img(string $key, int $width = 1200, ?int $height = null): string
    {
        if (! is_file(public_path('images/'.$key.'.jpg'))) {
            $key = 'bottles';
        }

        return asset(($width <= 400 ? 'images/thumbs/' : 'images/').$key.'.jpg');
    }
}

if (! function_exists('ugx')) {
    function ugx(float|int|string|null $amount): string
    {
        return 'UGX '.number_format((float) $amount);
    }
}

if (! function_exists('kg')) {
    function kg(float|int|string|null $value): string
    {
        $value = (float) $value;

        return rtrim(rtrim(number_format($value, 2), '0'), '.').' kg';
    }
}
