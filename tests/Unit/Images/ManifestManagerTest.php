<?php

namespace Quepenny\Livewire\Tests\Unit\Images;

use PHPUnit\Framework\TestCase;
use Quepenny\Livewire\Services\Images\ManifestManager;
use Quepenny\Livewire\Tests\Traits\InteractsWithImageFolders;

class ManifestManagerTest extends TestCase
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

    public function test_a_missing_manifest_loads_as_an_empty_array(): void
    {
        $this->assertSame([], (new ManifestManager)->load($this->makeFolder('team')));
    }

    /**
     * The manifest sits in a folder the application is free to edit by hand, so
     * unreadable JSON degrades to "nothing is tracked" and the next run simply
     * rebuilds, rather than fataling.
     */
    public function test_a_corrupt_manifest_loads_as_an_empty_array(): void
    {
        $folder = $this->makeFolder('team');
        file_put_contents($folder.DIRECTORY_SEPARATOR.'.qp-images-manifest.json', '{not json');

        $this->assertSame([], (new ManifestManager)->load($folder));
    }

    public function test_a_saved_manifest_round_trips(): void
    {
        $folder = $this->makeFolder('team');
        $manager = new ManifestManager;

        $manifest = [
            'one.png' => ['output' => 'one.a7f8c2b1.webp', 'hash' => 'a7f8c2b1'],
            'two.png' => ['output' => 'two.b1c2d3e4.webp', 'hash' => 'b1c2d3e4'],
        ];

        $manager->save($folder, $manifest);

        $this->assertFileExists($folder.DIRECTORY_SEPARATOR.'.qp-images-manifest.json');
        $this->assertSame($manifest, $manager->load($folder));
    }

    /**
     * The manifest is committed alongside the generated assets, so its key
     * order must not depend on the order the folder happened to be scanned in.
     */
    public function test_a_saved_manifest_is_sorted_for_stable_diffs(): void
    {
        $folder = $this->makeFolder('team');
        $manager = new ManifestManager;

        $manager->save($folder, [
            'zebra.png' => ['output' => 'zebra.1.webp', 'hash' => '1'],
            'apple.png' => ['output' => 'apple.2.webp', 'hash' => '2'],
            'mango.png' => ['output' => 'mango.3.webp', 'hash' => '3'],
        ]);

        $this->assertSame(['apple.png', 'mango.png', 'zebra.png'], array_keys($manager->load($folder)));
    }

    public function test_saving_an_empty_manifest_removes_the_file(): void
    {
        $folder = $this->makeFolder('team');
        $manager = new ManifestManager;
        $path = $folder.DIRECTORY_SEPARATOR.'.qp-images-manifest.json';

        $manager->save($folder, ['one.png' => ['output' => 'one.a1.webp', 'hash' => 'a1']]);
        $this->assertFileExists($path);

        $manager->save($folder, []);
        $this->assertFileDoesNotExist($path);
    }

    public function test_the_manifest_filename_is_configurable(): void
    {
        $folder = $this->makeFolder('team');
        $manager = new ManifestManager('.images.json');

        $manager->save($folder, ['one.png' => ['output' => 'one.a1.webp', 'hash' => 'a1']]);

        $this->assertSame($folder.DIRECTORY_SEPARATOR.'.images.json', $manager->path($folder));
        $this->assertFileExists($folder.DIRECTORY_SEPARATOR.'.images.json');
    }

    public function test_a_trailing_separator_on_the_folder_does_not_double_up(): void
    {
        $folder = $this->makeFolder('team');
        $manager = new ManifestManager;

        $this->assertSame(
            $folder.DIRECTORY_SEPARATOR.'.qp-images-manifest.json',
            $manager->path($folder.DIRECTORY_SEPARATOR),
        );
    }

    public function test_entry_returns_the_record_for_an_original_or_null(): void
    {
        $manager = new ManifestManager;
        $manifest = ['one.png' => ['output' => 'one.a1.webp', 'hash' => 'a1']];

        $this->assertSame(['output' => 'one.a1.webp', 'hash' => 'a1'], $manager->entry($manifest, 'one.png'));
        $this->assertNull($manager->entry($manifest, 'two.png'));
    }
}
