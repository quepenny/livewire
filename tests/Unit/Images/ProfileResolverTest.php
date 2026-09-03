<?php

namespace Quepenny\Livewire\Tests\Unit\Images;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Quepenny\Livewire\Services\Images\ProfileResolver;
use Quepenny\Livewire\Tests\Traits\InteractsWithImageFolders;

class ProfileResolverTest extends TestCase
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

    /**
     * @param  array<string, array<string, mixed>>  $profiles
     * @param  array<string, mixed>  $defaults
     */
    protected function resolver(array $profiles, array $defaults = []): ProfileResolver
    {
        return new ProfileResolver($this->basePath, $profiles, $defaults);
    }

    public function test_defaults_are_merged_beneath_a_profile(): void
    {
        $resolver = $this->resolver(
            profiles: ['team' => ['width' => 300, 'quality' => 90]],
            defaults: ['quality' => 80, 'format' => 'webp', 'delete_originals' => false],
        );

        $this->assertSame([
            'quality' => 90,
            'format' => 'webp',
            'delete_originals' => false,
            'width' => 300,
        ], $resolver->resolve('team'));
    }

    public function test_an_unknown_profile_resolves_to_null(): void
    {
        $resolver = $this->resolver(['team' => ['width' => 300]]);

        $this->assertFalse($resolver->has('hero'));
        $this->assertNull($resolver->resolve('hero'));
    }

    /**
     * A "default" profile turns the folder list into an opt-out rather than an
     * opt-in, so every folder beneath the base path becomes processable.
     */
    public function test_a_default_profile_catches_unnamed_folders(): void
    {
        $resolver = $this->resolver(
            profiles: ['default' => ['width' => 1200]],
            defaults: ['quality' => 80, 'format' => 'webp'],
        );

        $this->assertTrue($resolver->has('anything-at-all'));
        $this->assertSame(
            ['quality' => 80, 'format' => 'webp', 'width' => 1200],
            $resolver->resolve('anything-at-all'),
        );
    }

    public function test_a_named_profile_wins_over_the_default_profile(): void
    {
        $resolver = $this->resolver([
            'default' => ['width' => 1200],
            'team' => ['width' => 300],
        ]);

        $this->assertSame(300, $resolver->resolve('team')['width']);
        $this->assertSame(1200, $resolver->resolve('hero')['width']);
    }

    /**
     * Width is the one setting with no sensible default: rendering without it
     * would silently pass the original through, so it fails loudly instead.
     */
    public function test_a_profile_without_a_usable_width_throws(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Profile [team] must define a positive integer width.');

        $this->resolver(['team' => ['quality' => 80]])->resolve('team');
    }

    public function test_a_non_positive_width_throws(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->resolver(['team' => ['width' => 0]])->resolve('team');
    }

    public function test_a_non_integer_width_throws(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->resolver(['team' => ['width' => '300']])->resolve('team');
    }

    public function test_discover_returns_only_configured_folders_that_exist(): void
    {
        $this->makeFolder('team');
        $this->makeFolder('hero');
        $this->makeFolder('screenshots');

        $resolver = $this->resolver([
            'team' => ['width' => 300],
            'hero' => ['width' => 1920],
            'missing-folder' => ['width' => 100],
        ]);

        $this->assertSame(['hero', 'team'], $resolver->discover());
    }

    public function test_discover_ignores_files_beside_the_profile_folders(): void
    {
        $this->makeFolder('team');
        file_put_contents($this->path('README.md'), 'not a folder');

        $resolver = $this->resolver(['team' => ['width' => 300], 'README.md' => ['width' => 300]]);

        $this->assertSame(['team'], $resolver->discover());
    }

    public function test_discover_returns_nothing_when_the_base_path_is_missing(): void
    {
        $resolver = new ProfileResolver(
            $this->path('does-not-exist'),
            ['team' => ['width' => 300]],
        );

        $this->assertSame([], $resolver->discover());
    }

    public function test_path_points_at_the_profile_folder(): void
    {
        $resolver = $this->resolver(['team' => ['width' => 300]]);

        $this->assertSame($this->basePath, $resolver->basePath());
        $this->assertSame($this->basePath.DIRECTORY_SEPARATOR.'team', $resolver->path('team'));
    }
}
