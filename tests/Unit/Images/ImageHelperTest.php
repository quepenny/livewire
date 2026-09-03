<?php

namespace Quepenny\Livewire\Tests\Unit\Images;

use Illuminate\Container\Container;
use PHPUnit\Framework\TestCase;
use Quepenny\Livewire\Services\Images\ImageUrlResolver;
use Quepenny\Livewire\Services\Images\ManifestManager;
use Quepenny\Livewire\Tests\Traits\InteractsWithImageFolders;

/**
 * The helper is the only part of the pipeline a view ever touches, so it is
 * tested against a real container binding rather than being taken on trust
 * from {@see ImageUrlResolverTest}.
 */
class ImageHelperTest extends TestCase
{
    use InteractsWithImageFolders;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpImageFolders();

        $container = new Container;

        $container->instance(
            ImageUrlResolver::class,
            new ImageUrlResolver($this->basePath, '/images', new ManifestManager),
        );

        Container::setInstance($container);
    }

    protected function tearDown(): void
    {
        Container::setInstance(null);

        $this->tearDownImageFolders();

        parent::tearDown();
    }

    public function test_qp_image_returns_the_fingerprinted_url(): void
    {
        (new ManifestManager)->save($this->makeFolder('how-it-works'), [
            'step-1.png' => ['output' => 'step-1.a7f8c2b1.webp', 'hash' => 'a7f8c2b1'],
        ]);

        $this->assertSame('/images/how-it-works/step-1.a7f8c2b1.webp', qp_image('how-it-works/step-1.png'));
    }

    public function test_qp_image_falls_back_to_the_original_path(): void
    {
        $this->makeFolder('how-it-works');

        $this->assertSame('/images/how-it-works/step-9.png', qp_image('how-it-works/step-9.png'));
    }
}
