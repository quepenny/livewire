<?php

namespace Quepenny\Livewire\Services\Images\Encoders;

use Intervention\Image\Encoders\AvifEncoder as InterventionAvifEncoder;
use Intervention\Image\Interfaces\EncoderInterface as InterventionEncoder;

class AvifEncoder implements ImageEncoder
{
    public function format(): string
    {
        return 'avif';
    }

    public function extension(): string
    {
        return 'avif';
    }

    public function supported(): bool
    {
        return function_exists('imageavif');
    }

    public function driverEncoder(int $quality): InterventionEncoder
    {
        return new InterventionAvifEncoder(quality: $quality);
    }
}
