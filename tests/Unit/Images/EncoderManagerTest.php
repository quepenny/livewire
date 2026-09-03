<?php

namespace Quepenny\Livewire\Tests\Unit\Images;

use Intervention\Image\Encoders\WebpEncoder as InterventionWebpEncoder;
use Intervention\Image\Interfaces\EncoderInterface as InterventionEncoder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Quepenny\Livewire\Services\Images\Encoders\AvifEncoder;
use Quepenny\Livewire\Services\Images\Encoders\EncoderManager;
use Quepenny\Livewire\Services\Images\Encoders\ImageEncoder;
use Quepenny\Livewire\Services\Images\Encoders\WebpEncoder;
use RuntimeException;
use stdClass;

class EncoderManagerTest extends TestCase
{
    /**
     * An encoder for a format this runtime cannot produce, standing in for
     * AVIF on a PHP build without it.
     */
    protected function unsupportedEncoder(): ImageEncoder
    {
        return new class implements ImageEncoder
        {
            public function format(): string
            {
                return 'heic';
            }

            public function extension(): string
            {
                return 'heic';
            }

            public function supported(): bool
            {
                return false;
            }

            public function driverEncoder(int $quality): InterventionEncoder
            {
                return new InterventionWebpEncoder(quality: $quality);
            }
        };
    }

    public function test_encoders_are_registered_from_a_config_style_map(): void
    {
        $manager = new EncoderManager([
            'webp' => WebpEncoder::class,
            'avif' => AvifEncoder::class,
        ]);

        $this->assertTrue($manager->has('webp'));
        $this->assertTrue($manager->has('avif'));
        $this->assertFalse($manager->has('png'));
    }

    public function test_an_encoder_can_be_registered_as_an_instance(): void
    {
        $manager = new EncoderManager;
        $manager->register('webp', new WebpEncoder);

        $this->assertInstanceOf(WebpEncoder::class, $manager->for('webp'));
    }

    /**
     * Registering without a key falls back to the encoder's own format, which
     * is what keeps a config map honest when someone omits the key.
     */
    public function test_registering_without_a_key_uses_the_encoders_own_format(): void
    {
        $manager = new EncoderManager;
        $manager->register(null, new WebpEncoder);

        $this->assertTrue($manager->has('webp'));
    }

    /**
     * The config key is what a profile's "format" is looked up by, so an
     * alias must resolve to whatever encoder it was mapped to.
     */
    public function test_the_config_key_wins_over_the_encoders_own_format(): void
    {
        $manager = new EncoderManager(['modern' => WebpEncoder::class]);

        $this->assertTrue($manager->has('modern'));
        $this->assertFalse($manager->has('webp'));
        $this->assertInstanceOf(WebpEncoder::class, $manager->for('modern'));
    }

    public function test_resolving_an_unregistered_format_throws(): void
    {
        $manager = new EncoderManager(['webp' => WebpEncoder::class]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No encoder registered for format [png]. Registered: [webp].');

        $manager->for('png');
    }

    /**
     * A format the runtime cannot produce has to fail before any file is
     * written, otherwise a profile switched to AVIF on an unsupporting build
     * would quietly emit broken assets.
     */
    public function test_resolving_a_format_the_runtime_cannot_produce_throws(): void
    {
        $manager = new EncoderManager;
        $manager->register('heic', $this->unsupportedEncoder());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The [heic] encoder is not supported by this PHP runtime.');

        $manager->for('heic');
    }

    public function test_registering_something_that_is_not_an_encoder_throws(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('must implement');

        new EncoderManager(['broken' => stdClass::class]);
    }

    public function test_extensions_lists_each_output_extension_once(): void
    {
        $manager = new EncoderManager([
            'webp' => WebpEncoder::class,
            'modern' => WebpEncoder::class,
            'avif' => AvifEncoder::class,
        ]);

        $extensions = $manager->extensions();

        sort($extensions);

        $this->assertSame(['avif', 'webp'], $extensions);
    }

    public function test_the_webp_encoder_describes_itself_and_builds_a_driver_encoder(): void
    {
        $encoder = new WebpEncoder;

        $this->assertSame('webp', $encoder->format());
        $this->assertSame('webp', $encoder->extension());
        $this->assertSame(function_exists('imagewebp'), $encoder->supported());
        $this->assertInstanceOf(InterventionEncoder::class, $encoder->driverEncoder(75));
    }

    public function test_the_avif_encoder_describes_itself_and_builds_a_driver_encoder(): void
    {
        $encoder = new AvifEncoder;

        $this->assertSame('avif', $encoder->format());
        $this->assertSame('avif', $encoder->extension());
        $this->assertSame(function_exists('imageavif'), $encoder->supported());
        $this->assertInstanceOf(InterventionEncoder::class, $encoder->driverEncoder(75));
    }
}
