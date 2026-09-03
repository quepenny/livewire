<?php

namespace Quepenny\Livewire\Services\Images;

/**
 * Resolves a source image path to its fingerprinted public URL.
 *
 * Given a path relative to the source directory (e.g. "how-it-works/step-1.png")
 * it locates the folder manifest, resolves the generated filename and returns a
 * public URL. When the manifest or entry is missing it falls back gracefully to
 * the original path so views never break.
 */
class ImageUrlResolver
{
    public function __construct(
        protected string $basePath,
        protected string $publicUrl,
        protected ManifestManager $manifests,
    ) {}

    public function resolve(string $path): string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        $folder = trim(dirname($path), '/.');
        $name = basename($path);

        if ($folder === '') {
            return $this->url($path);
        }

        $manifest = $this->manifests->load($this->basePath.DIRECTORY_SEPARATOR.$folder);
        $entry = $this->manifests->entry($manifest, $name);

        if ($entry === null) {
            return $this->url($path);
        }

        return $this->url($folder.'/'.$entry['output']);
    }

    protected function url(string $relative): string
    {
        return rtrim($this->publicUrl, '/').'/'.ltrim($relative, '/');
    }
}
