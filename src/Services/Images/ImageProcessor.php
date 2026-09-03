<?php

namespace Quepenny\Livewire\Services\Images;

use Intervention\Image\ImageManager;
use Quepenny\Livewire\Services\Images\Encoders\EncoderManager;
use Quepenny\Livewire\Support\Images\ProfileResult;
use Throwable;

/**
 * Orchestrates the processing of image profile folders.
 *
 * Responsibilities:
 *   - discover source files for a profile
 *   - fingerprint each file against its profile
 *   - skip unchanged files using the manifest (idempotency)
 *   - resize + encode changed files via the configured encoder
 *   - remove obsolete generated files and (optionally) originals
 *   - keep the folder manifest in sync
 *
 * All rendering delegates to Intervention; all fingerprinting, manifest and
 * profile logic lives in the injected collaborators. Estimated dry-run savings
 * assume a typical modern-format reduction and are deliberately conservative.
 */
class ImageProcessor
{
    /** Rough reduction factor used only for dry-run "estimated savings". */
    protected const ESTIMATED_REDUCTION = 0.65;

    /**
     * @param  list<string>  $sourceFormats
     */
    public function __construct(
        protected ImageManager $images,
        protected EncoderManager $encoders,
        protected ProfileResolver $profiles,
        protected ManifestManager $manifests,
        protected HashGenerator $hasher,
        protected array $sourceFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp'],
    ) {}

    /**
     * Process every discovered profile folder.
     *
     * @return array<string, ProfileResult>
     */
    public function processAll(bool $force = false, bool $dryRun = false): array
    {
        $results = [];

        foreach ($this->profiles->discover() as $profile) {
            $results[$profile] = $this->process($profile, $force, $dryRun);
        }

        return $results;
    }

    /**
     * Process a single profile folder.
     */
    public function process(string $profile, bool $force = false, bool $dryRun = false): ProfileResult
    {
        $result = new ProfileResult($profile);

        // A malformed profile or an unusable encoder is a folder-wide problem
        // rather than a per-file one. It is reported like any other failure so
        // that one bad profile never aborts the folders either side of it.
        try {
            $settings = $this->profiles->resolve($profile);

            if ($settings === null) {
                return $result;
            }

            $encoder = $this->encoders->for($settings['format']);
        } catch (Throwable $e) {
            $result->markUnprocessable($e->getMessage());

            return $result;
        }

        $dir = $this->profiles->path($profile);

        if (! is_dir($dir)) {
            return $result;
        }

        $manifest = $this->manifests->load($dir);
        $outputs = $this->manifestOutputs($manifest);

        foreach ($this->sources($dir, $outputs) as $original) {
            $result->found++;

            $source = $dir.DIRECTORY_SEPARATOR.$original;
            $hash = $this->hasher->forFile($source, $settings);
            $outputName = $this->outputName($original, $hash, $encoder->extension());
            $entry = $this->manifests->entry($manifest, $original);

            $fresh = ! $force
                && $entry !== null
                && $entry['hash'] === $hash
                && is_file($dir.DIRECTORY_SEPARATOR.$entry['output']);

            if ($fresh) {
                $result->markSkipped($original);

                continue;
            }

            if ($dryRun) {
                $result->markProcessed(
                    $original,
                    (int) round((int) @filesize($source) * self::ESTIMATED_REDUCTION),
                );

                continue;
            }

            try {
                $image = $this->images->read($source);
            } catch (Throwable $e) {
                $result->markFailed($original, $e->getMessage());

                continue;
            }

            $originalSize = (int) @filesize($source);

            $image->scaleDown(width: $settings['width']);
            $encoded = $image->encode($encoder->driverEncoder($settings['quality']));
            $encoded->save($dir.DIRECTORY_SEPARATOR.$outputName);
            $outputSize = $encoded->size();

            $this->removeObsolete($dir, $entry, $outputName, $result);

            $manifest[$original] = ['output' => $outputName, 'hash' => $hash];

            if ($settings['delete_originals']) {
                @unlink($source);
                $result->markProcessed($original, $originalSize);
            } else {
                $result->markProcessed($original, max(0, $originalSize - $outputSize));
            }
        }

        if (! $dryRun) {
            $this->manifests->save($dir, $manifest);
        }

        return $result;
    }

    /**
     * Remove generated files in a profile folder that are no longer referenced
     * by the manifest.
     */
    public function clean(string $profile): ProfileResult
    {
        $result = new ProfileResult($profile);

        $dir = $this->profiles->path($profile);

        if (! is_dir($dir)) {
            return $result;
        }

        $manifest = $this->manifests->load($dir);

        // Anything the manifest knows about is spoken for, whether as a source
        // or as the asset generated from one.
        $tracked = $this->manifestOutputs($manifest) + array_fill_keys(array_keys($manifest), true);

        foreach (scandir($dir) ?: [] as $entry) {
            $path = $dir.DIRECTORY_SEPARATOR.$entry;

            if (! is_file($path) || isset($tracked[$entry])) {
                continue;
            }

            if ($this->isGenerated($entry)) {
                $bytes = (int) @filesize($path);
                @unlink($path);
                $result->markRemoved($entry, $bytes);
            }
        }

        return $result;
    }

    /**
     * Discover processable source files, excluding the manifest and any file
     * that is itself a generated asset.
     *
     * The manifest is the first line of defence, but it cannot be the only
     * one: a folder whose manifest has been deleted would otherwise feed its
     * own output back in as a source and re-encode it on every run. Anything
     * shaped like a generated asset is therefore skipped regardless.
     *
     * @param  array<string, true|mixed>  $outputs
     * @return list<string>
     */
    protected function sources(string $dir, array $outputs): array
    {
        $files = [];

        foreach (scandir($dir) ?: [] as $entry) {
            if (! is_file($dir.DIRECTORY_SEPARATOR.$entry) || isset($outputs[$entry])) {
                continue;
            }

            if ($this->isGenerated($entry)) {
                continue;
            }

            $extension = strtolower(pathinfo($entry, PATHINFO_EXTENSION));

            if (in_array($extension, $this->sourceFormats, true)) {
                $files[] = $entry;
            }
        }

        sort($files);

        return $files;
    }

    /**
     * @param  array<string, array{output: string, hash: string}>  $manifest
     * @return array<string, true>
     */
    protected function manifestOutputs(array $manifest): array
    {
        $outputs = [];

        foreach ($manifest as $entry) {
            if (isset($entry['output'])) {
                $outputs[$entry['output']] = true;
            }
        }

        return $outputs;
    }

    /**
     * Whether a filename has the shape this pipeline gives its output:
     * base.<hash>.<encoder extension>.
     *
     * The hash segment is matched at exactly the configured length so that an
     * ordinary source file which merely happens to carry a dotted, hex-looking
     * segment - photo.2024.webp, say - is neither mistaken for a generated
     * asset here nor swept up by {@see clean}.
     */
    protected function isGenerated(string $filename): bool
    {
        $extensions = array_map('preg_quote', $this->encoders->extensions());

        if ($extensions === []) {
            return false;
        }

        return (bool) preg_match(
            '/^.+\.[0-9a-f]{'.$this->hasher->length().'}\.(?:'.implode('|', $extensions).')$/i',
            $filename,
        );
    }

    protected function outputName(string $original, string $hash, string $extension): string
    {
        $base = pathinfo($original, PATHINFO_FILENAME);

        return "{$base}.{$hash}.{$extension}";
    }

    /**
     * Remove the previous generated file for an entry when it has been
     * superseded by a new fingerprint.
     *
     * @param  array{output: string, hash: string}|null  $entry
     */
    protected function removeObsolete(string $dir, ?array $entry, string $outputName, ProfileResult $result): void
    {
        if ($entry === null || $entry['output'] === $outputName) {
            return;
        }

        $obsolete = $dir.DIRECTORY_SEPARATOR.$entry['output'];

        if (is_file($obsolete)) {
            $bytes = (int) @filesize($obsolete);
            @unlink($obsolete);
            $result->markRemoved($entry['output'], $bytes);
        }
    }
}
