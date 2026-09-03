<?php

namespace Quepenny\Livewire\Services\Images\Encoders;

use InvalidArgumentException;
use RuntimeException;

/**
 * Resolves output encoders by format key.
 *
 * The registry is populated from config so consuming applications can swap or
 * extend encoders (for example, enabling AVIF) without touching package code.
 */
class EncoderManager
{
    /**
     * @var array<string, ImageEncoder>
     */
    protected array $encoders = [];

    /**
     * @param  array<string, class-string<ImageEncoder>|ImageEncoder>  $encoders
     */
    public function __construct(array $encoders = [])
    {
        foreach ($encoders as $format => $encoder) {
            $this->register(is_string($format) ? $format : null, $encoder);
        }
    }

    /**
     * @param  class-string<ImageEncoder>|ImageEncoder  $encoder
     */
    public function register(?string $format, string|ImageEncoder $encoder): void
    {
        $instance = is_string($encoder) ? new $encoder : $encoder;

        if (! $instance instanceof ImageEncoder) {
            throw new InvalidArgumentException(sprintf(
                'Encoder [%s] must implement %s.',
                is_object($encoder) ? $encoder::class : $encoder,
                ImageEncoder::class,
            ));
        }

        $this->encoders[$format ?? $instance->format()] = $instance;
    }

    public function has(string $format): bool
    {
        return isset($this->encoders[$format]);
    }

    /**
     * Every distinct output extension the registered encoders can produce.
     *
     * @return list<string>
     */
    public function extensions(): array
    {
        return array_values(array_unique(
            array_map(fn (ImageEncoder $e) => $e->extension(), $this->encoders),
        ));
    }

    /**
     * Resolve the encoder for a format, ensuring the runtime supports it.
     */
    public function for(string $format): ImageEncoder
    {
        if (! $this->has($format)) {
            throw new InvalidArgumentException(sprintf(
                'No encoder registered for format [%s]. Registered: [%s].',
                $format,
                implode(', ', array_keys($this->encoders)) ?: 'none',
            ));
        }

        $encoder = $this->encoders[$format];

        if (! $encoder->supported()) {
            throw new RuntimeException(sprintf(
                'The [%s] encoder is not supported by this PHP runtime.',
                $format,
            ));
        }

        return $encoder;
    }
}
