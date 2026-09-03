<?php

namespace Quepenny\Livewire\Services\Images;

/**
 * Reads and writes the per-folder manifest that tracks generated assets.
 *
 * The manifest is keyed by the original filename and records the generated
 * output filename and its fingerprint:
 *
 *   {
 *     "step-1.png": { "output": "step-1.a7f8c2b1.webp", "hash": "a7f8c2b1" }
 *   }
 */
class ManifestManager
{
    public function __construct(protected string $filename = '.qp-images-manifest.json') {}

    public function path(string $folder): string
    {
        return rtrim($folder, DIRECTORY_SEPARATOR.'/').DIRECTORY_SEPARATOR.$this->filename;
    }

    /**
     * Load a folder's manifest as an associative array.
     *
     * @return array<string, array{output: string, hash: string}>
     */
    public function load(string $folder): array
    {
        $path = $this->path($folder);

        if (! is_file($path)) {
            return [];
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Persist a folder's manifest, sorted by key for stable diffs. An empty
     * manifest removes the file to avoid leaving noise behind.
     *
     * @param  array<string, array{output: string, hash: string}>  $manifest
     */
    public function save(string $folder, array $manifest): void
    {
        $path = $this->path($folder);

        if ($manifest === []) {
            if (is_file($path)) {
                @unlink($path);
            }

            return;
        }

        ksort($manifest);

        file_put_contents(
            $path,
            json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL,
        );
    }

    /**
     * Look up the manifest entry for an original filename.
     *
     * @param  array<string, array{output: string, hash: string}>  $manifest
     * @return array{output: string, hash: string}|null
     */
    public function entry(array $manifest, string $original): ?array
    {
        return $manifest[$original] ?? null;
    }
}
