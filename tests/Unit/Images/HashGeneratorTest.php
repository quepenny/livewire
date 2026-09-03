<?php

namespace Quepenny\Livewire\Tests\Unit\Images;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Quepenny\Livewire\Services\Images\HashGenerator;
use Quepenny\Livewire\Tests\Traits\InteractsWithImageFolders;

class HashGeneratorTest extends TestCase
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

    public function test_hash_is_deterministic_for_the_same_file_and_profile(): void
    {
        $file = $this->writeImage('hero/one.png');
        $profile = ['width' => 480, 'quality' => 75, 'format' => 'webp'];

        $generator = new HashGenerator;

        $this->assertSame(
            $generator->forFile($file, $profile),
            $generator->forFile($file, $profile),
        );
    }

    public function test_hash_length_honours_the_configured_length(): void
    {
        $file = $this->writeImage('hero/one.png');
        $profile = ['width' => 480, 'quality' => 75, 'format' => 'webp'];

        $this->assertSame(8, strlen((new HashGenerator)->forFile($file, $profile)));
        $this->assertSame(16, strlen((new HashGenerator(16))->forFile($file, $profile)));
        $this->assertMatchesRegularExpression('/^[0-9a-f]{8}$/', (new HashGenerator)->forFile($file, $profile));
    }

    public function test_the_configured_length_is_exposed(): void
    {
        $this->assertSame(8, (new HashGenerator)->length());
        $this->assertSame(16, (new HashGenerator(16))->length());
    }

    public function test_hash_changes_when_the_file_contents_change(): void
    {
        $profile = ['width' => 480, 'quality' => 75, 'format' => 'webp'];
        $generator = new HashGenerator;

        $file = $this->writeImage('hero/one.png', seed: 1);
        $before = $generator->forFile($file, $profile);

        $this->writeImage('hero/one.png', seed: 2);
        $after = $generator->forFile($file, $profile);

        $this->assertNotSame($before, $after);
    }

    /**
     * The fingerprint exists so a profile change busts the browser cache just
     * as a source change does, so each rendering-relevant setting has to move
     * the hash on its own.
     */
    public function test_hash_changes_when_a_rendering_setting_changes(): void
    {
        $file = $this->writeImage('hero/one.png');
        $generator = new HashGenerator;

        $base = $generator->forFile($file, ['width' => 480, 'quality' => 75, 'format' => 'webp']);

        $this->assertNotSame($base, $generator->forFile($file, ['width' => 960, 'quality' => 75, 'format' => 'webp']));
        $this->assertNotSame($base, $generator->forFile($file, ['width' => 480, 'quality' => 90, 'format' => 'webp']));
        $this->assertNotSame($base, $generator->forFile($file, ['width' => 480, 'quality' => 75, 'format' => 'avif']));
    }

    /**
     * Settings that do not affect the rendered output must not rebuild every
     * asset, so anything outside width/quality/format is ignored - as is the
     * order the keys happen to be declared in.
     */
    public function test_hash_ignores_settings_that_do_not_affect_the_output(): void
    {
        $file = $this->writeImage('hero/one.png');
        $generator = new HashGenerator;

        $base = $generator->forFile($file, ['width' => 480, 'quality' => 75, 'format' => 'webp']);

        $this->assertSame($base, $generator->forFile($file, [
            'width' => 480,
            'quality' => 75,
            'format' => 'webp',
            'delete_originals' => true,
            'some_future_key' => 'anything',
        ]));

        $this->assertSame($base, $generator->forFile($file, [
            'format' => 'webp',
            'quality' => 75,
            'width' => 480,
        ]));
    }

    public function test_hash_from_contents_matches_hash_from_an_identical_file(): void
    {
        $file = $this->writeImage('hero/one.png');
        $profile = ['width' => 480, 'quality' => 75, 'format' => 'webp'];

        $generator = new HashGenerator;

        $this->assertSame(
            $generator->forFile($file, $profile),
            $generator->forContents((string) file_get_contents($file), $profile),
        );
    }

    public function test_hashing_a_missing_file_throws(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to hash missing file');

        (new HashGenerator)->forFile($this->path('hero/nope.png'), ['width' => 480]);
    }
}
