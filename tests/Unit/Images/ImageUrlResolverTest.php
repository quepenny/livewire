<?php

namespace Quepenny\Livewire\Tests\Unit\Images;

use PHPUnit\Framework\TestCase;
use Quepenny\Livewire\Services\Images\ImageUrlResolver;
use Quepenny\Livewire\Services\Images\ManifestManager;
use Quepenny\Livewire\Tests\Traits\InteractsWithImageFolders;

class ImageUrlResolverTest extends TestCase
{
    use InteractsWithImageFolders;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpImageFolders();
    }

    protected function tearDown(): void
    {
        $this->tearDownImageFolders();

        parent::tearDown();
    }

    protected function resolver(string $publicUrl = '/images'): ImageUrlResolver
    {
        return new ImageUrlResolver($this->basePath, $publicUrl, new ManifestManager);
    }

    /**
     * Seed a folder manifest without running the processor, so the resolver is
     * tested against the contract rather than against a rendered file.
     *
     * @param  array<string, array{output: string, hash: string}>  $manifest
     */
    protected function seedManifest(string $profile, array $manifest): void
    {
        (new ManifestManager)->save($this->makeFolder($profile), $manifest);
    }

    public function test_a_tracked_image_resolves_to_its_fingerprinted_url(): void
    {
        $this->seedManifest('how-it-works', [
            'step-1.png' => ['output' => 'step-1.a7f8c2b1.webp', 'hash' => 'a7f8c2b1'],
        ]);

        $this->assertSame(
            '/images/how-it-works/step-1.a7f8c2b1.webp',
            $this->resolver()->resolve('how-it-works/step-1.png'),
        );
    }

    /**
     * Views must never break because an image has not been processed yet, so
     * an untracked path is handed back untouched rather than being dropped.
     */
    public function test_an_untracked_image_falls_back_to_the_original_path(): void
    {
        $this->seedManifest('how-it-works', [
            'step-1.png' => ['output' => 'step-1.a7f8c2b1.webp', 'hash' => 'a7f8c2b1'],
        ]);

        $this->assertSame(
            '/images/how-it-works/step-2.png',
            $this->resolver()->resolve('how-it-works/step-2.png'),
        );
    }

    public function test_a_folder_with_no_manifest_falls_back_to_the_original_path(): void
    {
        $this->makeFolder('team');

        $this->assertSame('/images/team/paul.png', $this->resolver()->resolve('team/paul.png'));
    }

    public function test_a_missing_folder_falls_back_to_the_original_path(): void
    {
        $this->assertSame('/images/nope/paul.png', $this->resolver()->resolve('nope/paul.png'));
    }

    /**
     * A path with no folder cannot belong to a profile, so it is passed
     * straight through without a manifest lookup.
     */
    public function test_a_path_without_a_folder_is_passed_through(): void
    {
        $this->assertSame('/images/logo.png', $this->resolver()->resolve('logo.png'));
    }

    public function test_a_leading_slash_is_tolerated(): void
    {
        $this->seedManifest('team', [
            'paul.png' => ['output' => 'paul.deadbeef.webp', 'hash' => 'deadbeef'],
        ]);

        $this->assertSame('/images/team/paul.deadbeef.webp', $this->resolver()->resolve('/team/paul.png'));
    }

    /**
     * Windows-style separators reach the helper whenever a path is built from
     * something the filesystem produced, so they normalise to URL separators.
     */
    public function test_backslashes_are_normalised(): void
    {
        $this->seedManifest('team', [
            'paul.png' => ['output' => 'paul.deadbeef.webp', 'hash' => 'deadbeef'],
        ]);

        $this->assertSame('/images/team/paul.deadbeef.webp', $this->resolver()->resolve('team\\paul.png'));
    }

    public function test_nested_folders_resolve(): void
    {
        $this->seedManifest('team/leadership', [
            'paul.png' => ['output' => 'paul.deadbeef.webp', 'hash' => 'deadbeef'],
        ]);

        $this->assertSame(
            '/images/team/leadership/paul.deadbeef.webp',
            $this->resolver()->resolve('team/leadership/paul.png'),
        );
    }

    public function test_the_public_url_prefix_is_configurable(): void
    {
        $this->seedManifest('team', [
            'paul.png' => ['output' => 'paul.deadbeef.webp', 'hash' => 'deadbeef'],
        ]);

        $this->assertSame(
            'https://cdn.example.com/assets/team/paul.deadbeef.webp',
            $this->resolver('https://cdn.example.com/assets/')->resolve('team/paul.png'),
        );
    }
}
