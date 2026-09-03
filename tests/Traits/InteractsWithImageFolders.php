<?php

namespace Quepenny\Livewire\Tests\Traits;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Quepenny\Livewire\Services\Images\Encoders\EncoderManager;
use Quepenny\Livewire\Services\Images\Encoders\WebpEncoder;
use Quepenny\Livewire\Services\Images\HashGenerator;
use Quepenny\Livewire\Services\Images\ImageProcessor;
use Quepenny\Livewire\Services\Images\ManifestManager;
use Quepenny\Livewire\Services\Images\ProfileResolver;

/**
 * Builds a throwaway public/images tree on disk for the image pipeline tests.
 *
 * The pipeline is filesystem-driven end to end, so the tests exercise real
 * folders and real GD-generated images rather than fixtures committed to the
 * repository. Everything is created beneath a per-test temporary directory
 * that {@see tearDownImageFolders} removes again.
 */
trait InteractsWithImageFolders
{
    protected string $basePath;

    protected function setUpImageFolders(): void
    {
        $this->basePath = sys_get_temp_dir()
            .DIRECTORY_SEPARATOR
            .'qp-images-'.bin2hex(random_bytes(6));

        mkdir($this->basePath, 0777, true);
    }

    protected function tearDownImageFolders(): void
    {
        if (isset($this->basePath)) {
            $this->deleteDirectory($this->basePath);
        }
    }

    /**
     * Create a profile folder beneath the temporary base path.
     */
    protected function makeFolder(string $profile): string
    {
        $path = $this->path($profile);

        is_dir($path) || mkdir($path, 0777, true);

        return $path;
    }

    protected function path(string $relative = ''): string
    {
        return $relative === ''
            ? $this->basePath
            : $this->basePath.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relative);
    }

    /**
     * Write a real PNG into a profile folder. The seed drives the fill colour
     * so two images of identical dimensions still differ in content, which is
     * what the fingerprinting needs in order to be exercised properly.
     */
    protected function writeImage(string $relative, int $width = 400, int $height = 200, int $seed = 1): string
    {
        $path = $this->path($relative);

        is_dir(dirname($path)) || mkdir(dirname($path), 0777, true);

        $image = imagecreatetruecolor($width, $height);

        // A two-tone fill: solid colours compress to near-identical sizes, and
        // a gradient keeps the encoded output large enough to be meaningful.
        $background = imagecolorallocate($image, $seed % 256, (int) ($seed * 7) % 256, (int) ($seed * 13) % 256);
        imagefilledrectangle($image, 0, 0, $width, $height, $background);

        for ($x = 0; $x < $width; $x++) {
            $stripe = imagecolorallocate($image, ($x + $seed) % 256, ($x * 3) % 256, ($x * 5 + $seed) % 256);
            imageline($image, $x, 0, $x, (int) ($height / 2), $stripe);
        }

        imagepng($image, $path);
        imagedestroy($image);

        return $path;
    }

    /**
     * @param  array<string, array<string, mixed>>  $profiles
     * @param  array<string, mixed>  $defaults
     * @param  list<string>|null  $sourceFormats
     */
    protected function makeProcessor(
        array $profiles,
        array $defaults = ['quality' => 80, 'format' => 'webp', 'delete_originals' => false],
        ?array $sourceFormats = null,
    ): ImageProcessor {
        return new ImageProcessor(
            new ImageManager(new Driver),
            new EncoderManager(['webp' => WebpEncoder::class]),
            new ProfileResolver($this->basePath, $profiles, $defaults),
            new ManifestManager,
            new HashGenerator,
            $sourceFormats ?? ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        );
    }

    /**
     * @return array<string, array{output: string, hash: string}>
     */
    protected function manifest(string $profile): array
    {
        return (new ManifestManager)->load($this->path($profile));
    }

    /**
     * The files present in a profile folder, excluding the manifest.
     *
     * @return list<string>
     */
    protected function files(string $profile): array
    {
        $files = array_values(array_filter(
            scandir($this->path($profile)) ?: [],
            fn (string $entry) => $entry !== '.'
                && $entry !== '..'
                && $entry !== '.qp-images-manifest.json'
                && is_file($this->path($profile).DIRECTORY_SEPARATOR.$entry),
        ));

        sort($files);

        return $files;
    }

    protected function deleteDirectory(string $directory): void
    {
        if (! is_dir($directory)) {
            return;
        }

        foreach (scandir($directory) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $path = $directory.DIRECTORY_SEPARATOR.$entry;

            is_dir($path) ? $this->deleteDirectory($path) : @unlink($path);
        }

        @rmdir($directory);
    }
}
