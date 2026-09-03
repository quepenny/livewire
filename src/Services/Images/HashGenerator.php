<?php

namespace Quepenny\Livewire\Services\Images;

use InvalidArgumentException;

/**
 * Produces content fingerprints for generated assets.
 *
 * The fingerprint is derived from the original file contents combined with the
 * resolved profile settings, so a change to either the source image or the
 * profile yields a new hash - and therefore a new filename. This mirrors the
 * way Laravel Vite versions build assets.
 */
class HashGenerator
{
    public function __construct(protected int $length = 8) {}

    /**
     * The number of hexadecimal characters a fingerprint occupies, which is
     * also what makes a generated filename recognisable as one.
     */
    public function length(): int
    {
        return $this->length;
    }

    /**
     * Generate the fingerprint for a source file under a given profile.
     *
     * @param  array<string, mixed>  $profile
     */
    public function forFile(string $path, array $profile): string
    {
        if (! is_file($path)) {
            throw new InvalidArgumentException("Unable to hash missing file [{$path}].");
        }

        return $this->hash(hash_file('sha256', $path), $profile);
    }

    /**
     * Generate a fingerprint from raw contents (useful in tests).
     *
     * @param  array<string, mixed>  $profile
     */
    public function forContents(string $contents, array $profile): string
    {
        return $this->hash(hash('sha256', $contents), $profile);
    }

    /**
     * @param  array<string, mixed>  $profile
     */
    protected function hash(string $contentHash, array $profile): string
    {
        $profileSignature = $this->normaliseProfile($profile);

        $digest = hash('sha256', $contentHash.'|'.$profileSignature);

        return substr($digest, 0, $this->length);
    }

    /**
     * Build a stable, order-independent signature for the profile settings that
     * influence output. Keys unrelated to rendering are ignored so that, for
     * example, renaming an unrelated config key never rebuilds every asset.
     *
     * @param  array<string, mixed>  $profile
     */
    protected function normaliseProfile(array $profile): string
    {
        $relevant = [
            'width' => $profile['width'] ?? null,
            'quality' => $profile['quality'] ?? null,
            'format' => $profile['format'] ?? null,
        ];

        ksort($relevant);

        return json_encode($relevant);
    }
}
