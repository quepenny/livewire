<?php

namespace Quepenny\Livewire\Services\Images\Encoders;

use Intervention\Image\Encoders\WebpEncoder as InterventionWebpEncoder;
use Intervention\Image\Interfaces\EncoderInterface as InterventionEncoder;

class WebpEncoder implements ImageEncoder
{
    public function format(): string
    {
        return 'webp';
    }

    public function extension(): string
    {
        return 'webp';
    }

    public function supported(): bool
    {
        return function_exists('imagewebp');
    }

    public function driverEncoder(int $quality): InterventionEncoder
    {
        return new InterventionWebpEncoder(quality: $quality);
    }
}
