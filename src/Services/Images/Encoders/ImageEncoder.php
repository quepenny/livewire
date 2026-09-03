<?php

namespace Quepenny\Livewire\Services\Images\Encoders;

use Intervention\Image\Interfaces\EncoderInterface as InterventionEncoder;

/**
 * Contract for a pluggable output encoder.
 *
 * Each encoder is responsible for a single output format. It exposes the file
 * extension used for generated assets and builds the underlying Intervention
 * encoder for a given quality. New formats (e.g. AVIF) are added by
 * implementing this interface and registering the class in config.
 */
interface ImageEncoder
{
    /**
     * The output format key this encoder handles (e.g. "webp").
     */
    public function format(): string;

    /**
     * The file extension for generated assets, without the leading dot.
     */
    public function extension(): string;

    /**
     * Whether the current runtime can produce this format.
     */
    public function supported(): bool;

    /**
     * Build the underlying Intervention encoder for the given quality.
     */
    public function driverEncoder(int $quality): InterventionEncoder;
}
