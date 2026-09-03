<?php

namespace Quepenny\Livewire\Tests\Unit\Images;

use PHPUnit\Framework\TestCase;
use Quepenny\Livewire\Tests\Traits\InteractsWithImageFolders;

class ImageProcessorTest extends TestCase
{
    use InteractsWithImageFolders;

    protected function setUp(): void
    {
        parent::setUp();

        function_exists('imagewebp') || $this->markTestSkipped('This PHP build cannot encode WebP.');

        $this->setUpImageFolders();
    }

    protected function tearDown(): void
    {
        $this->tearDownImageFolders();

        parent::tearDown();
    }

    public function test_a_source_image_is_rendered_fingerprinted_and_recorded(): void
    {
        $this->writeImage('team/paul.png', width: 800, height: 400);

        $result = $this->makeProcessor(['team' => ['width' => 300]])->process('team');

        $this->assertSame(1, $result->found);
        $this->assertSame(['paul.png'], $result->processed);
        $this->assertSame([], $result->skipped);
        $this->assertSame([], $result->failed);

        $manifest = $this->manifest('team');
        $output = $manifest['paul.png']['output'];

        $this->assertMatchesRegularExpression('/^paul\.[0-9a-f]{8}\.webp$/', $output);
        $this->assertSame(substr($output, 5, 8), $manifest['paul.png']['hash']);
        $this->assertFileExists($this->path('team').DIRECTORY_SEPARATOR.$output);
    }

    public function test_the_image_is_resized_to_the_profile_width(): void
    {
        $this->writeImage('team/paul.png', width: 800, height: 400);

        $this->makeProcessor(['team' => ['width' => 300]])->process('team');

        $output = $this->manifest('team')['paul.png']['output'];
        $rendered = imagecreatefromwebp($this->path('team').DIRECTORY_SEPARATOR.$output);

        $this->assertSame(300, imagesx($rendered));
        $this->assertSame(150, imagesy($rendered), 'The aspect ratio should be preserved.');
    }

    /**
     * scaleDown never enlarges, so a source narrower than the profile keeps its
     * own dimensions instead of being blown up into a blurry asset.
     */
    public function test_an_image_narrower_than_the_profile_is_not_upscaled(): void
    {
        $this->writeImage('team/paul.png', width: 120, height: 60);

        $this->makeProcessor(['team' => ['width' => 300]])->process('team');

        $output = $this->manifest('team')['paul.png']['output'];
        $rendered = imagecreatefromwebp($this->path('team').DIRECTORY_SEPARATOR.$output);

        $this->assertSame(120, imagesx($rendered));
        $this->assertSame(60, imagesy($rendered));
    }

    /**
     * The whole point of the manifest: a second run over an unchanged folder
     * must do no work at all, so the command is safe to wire into a deploy.
     */
    public function test_a_second_run_skips_unchanged_images(): void
    {
        $this->writeImage('team/paul.png');

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);
        $processor->process('team');

        $before = $this->files('team');
        $result = $processor->process('team');

        $this->assertSame(1, $result->found, 'The generated asset must not be picked up as a new source.');
        $this->assertSame(['paul.png'], $result->skipped);
        $this->assertSame([], $result->processed);
        $this->assertSame($before, $this->files('team'));
    }

    public function test_force_rebuilds_even_when_nothing_has_changed(): void
    {
        $this->writeImage('team/paul.png');

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);
        $processor->process('team');

        $result = $processor->process('team', force: true);

        $this->assertSame(['paul.png'], $result->processed);
        $this->assertSame([], $result->skipped);
    }

    /**
     * A missing generated file is a changed folder as far as the pipeline is
     * concerned, so deleting an output rebuilds it without needing --force.
     */
    public function test_a_deleted_output_is_rebuilt(): void
    {
        $this->writeImage('team/paul.png');

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);
        $processor->process('team');

        $output = $this->manifest('team')['paul.png']['output'];
        unlink($this->path('team').DIRECTORY_SEPARATOR.$output);

        $result = $processor->process('team');

        $this->assertSame(['paul.png'], $result->processed);
        $this->assertFileExists($this->path('team').DIRECTORY_SEPARATOR.$output);
    }

    public function test_a_changed_source_replaces_its_obsolete_output(): void
    {
        $this->writeImage('team/paul.png', seed: 1);

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);
        $processor->process('team');
        $first = $this->manifest('team')['paul.png']['output'];

        $this->writeImage('team/paul.png', seed: 99);
        $result = $processor->process('team');
        $second = $this->manifest('team')['paul.png']['output'];

        $this->assertNotSame($first, $second);
        $this->assertSame([$first], $result->removed);
        $this->assertFileDoesNotExist($this->path('team').DIRECTORY_SEPARATOR.$first);
        $this->assertFileExists($this->path('team').DIRECTORY_SEPARATOR.$second);
        $this->assertSame([$second, 'paul.png'], $this->files('team'));
    }

    /**
     * Editing a profile has to bust the cache the same way editing an image
     * does, otherwise browsers keep serving assets at the old width.
     */
    public function test_a_changed_profile_replaces_its_obsolete_output(): void
    {
        $this->writeImage('team/paul.png', width: 800, height: 400);

        $this->makeProcessor(['team' => ['width' => 300]])->process('team');
        $first = $this->manifest('team')['paul.png']['output'];

        $result = $this->makeProcessor(['team' => ['width' => 600]])->process('team');
        $second = $this->manifest('team')['paul.png']['output'];

        $this->assertNotSame($first, $second);
        $this->assertSame([$first], $result->removed);
        $this->assertFileDoesNotExist($this->path('team').DIRECTORY_SEPARATOR.$first);

        $rendered = imagecreatefromwebp($this->path('team').DIRECTORY_SEPARATOR.$second);
        $this->assertSame(600, imagesx($rendered));
    }

    /**
     * delete_originals is what lets a folder hold only web-ready assets. The
     * whole original is reclaimed, so the reported saving is its full size.
     */
    public function test_originals_are_deleted_when_the_profile_asks(): void
    {
        $source = $this->writeImage('team/paul.png', width: 800, height: 400);
        $originalSize = filesize($source);

        $result = $this->makeProcessor(['team' => ['width' => 300, 'delete_originals' => true]])->process('team');

        $this->assertFileDoesNotExist($source);
        $this->assertSame($originalSize, $result->bytesSaved);
        $this->assertCount(1, $this->files('team'));
    }

    public function test_originals_are_kept_by_default(): void
    {
        $source = $this->writeImage('team/paul.png', width: 800, height: 400);

        $this->makeProcessor(['team' => ['width' => 300]])->process('team');

        $this->assertFileExists($source);
        $this->assertCount(2, $this->files('team'));
    }

    public function test_files_outside_the_source_formats_are_ignored(): void
    {
        $this->writeImage('team/paul.png');
        file_put_contents($this->path('team/notes.txt'), 'ignore me');
        file_put_contents($this->path('team/paul.svg'), '<svg></svg>');

        $result = $this->makeProcessor(['team' => ['width' => 300]])->process('team');

        $this->assertSame(1, $result->found);
        $this->assertSame(['paul.png'], $result->processed);
        $this->assertFileExists($this->path('team/notes.txt'));
        $this->assertFileExists($this->path('team/paul.svg'));
    }

    /**
     * A file that is not a decodable image is reported and stepped over, so one
     * bad asset never aborts the rest of the folder.
     */
    public function test_an_undecodable_image_is_reported_and_the_run_continues(): void
    {
        $this->writeImage('team/paul.png');
        file_put_contents($this->path('team/broken.png'), 'not an image');

        $result = $this->makeProcessor(['team' => ['width' => 300]])->process('team');

        $this->assertSame(2, $result->found);
        $this->assertSame(['paul.png'], $result->processed);
        $this->assertCount(1, $result->failed);
        $this->assertSame('broken.png', $result->failed[0]['file']);
        $this->assertArrayNotHasKey('broken.png', $this->manifest('team'));
    }

    public function test_a_dry_run_reports_without_writing_anything(): void
    {
        $this->writeImage('team/paul.png', width: 800, height: 400);
        $this->writeImage('team/ola.png', width: 800, height: 400, seed: 4);

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);
        $result = $processor->process('team', dryRun: true);

        $this->assertSame(2, $result->found);
        $this->assertSame(['ola.png', 'paul.png'], $result->processed);
        $this->assertGreaterThan(0, $result->bytesSaved);
        $this->assertSame(['ola.png', 'paul.png'], $this->files('team'));
        $this->assertSame([], $this->manifest('team'));
    }

    public function test_a_dry_run_still_reports_unchanged_images_as_skipped(): void
    {
        $this->writeImage('team/paul.png');

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);
        $processor->process('team');

        $result = $processor->process('team', dryRun: true);

        $this->assertSame(['paul.png'], $result->skipped);
        $this->assertSame([], $result->processed);
    }

    public function test_process_all_covers_every_discovered_profile(): void
    {
        $this->writeImage('team/paul.png');
        $this->writeImage('hero/banner.png', width: 2400, height: 800);
        $this->writeImage('screenshots/one.png');

        $results = $this->makeProcessor([
            'team' => ['width' => 300],
            'hero' => ['width' => 1920],
        ])->processAll();

        $this->assertSame(['hero', 'team'], array_keys($results));
        $this->assertSame(['banner.png'], $results['hero']->processed);
        $this->assertSame(['paul.png'], $results['team']->processed);
        $this->assertSame(['one.png'], $this->files('screenshots'), 'An unconfigured folder is left alone.');
    }

    public function test_an_unconfigured_or_missing_profile_does_nothing(): void
    {
        $this->writeImage('screenshots/one.png');

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);

        $this->assertSame(0, $processor->process('screenshots')->found);
        $this->assertSame(0, $processor->process('team')->found);
        $this->assertSame(['one.png'], $this->files('screenshots'));
    }

    public function test_clean_removes_orphaned_generated_files_only(): void
    {
        $this->writeImage('team/paul.png');

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);
        $processor->process('team');

        $tracked = $this->manifest('team')['paul.png']['output'];

        // A generated file left behind by an earlier profile, alongside files
        // that only look similar and must survive.
        file_put_contents($this->path('team/paul.deadbeef.webp'), 'orphan');
        file_put_contents($this->path('team/logo.webp'), 'a plain source, not generated');
        file_put_contents($this->path('team/notes.txt'), 'unrelated');

        $result = $processor->clean('team');

        $this->assertSame(['paul.deadbeef.webp'], $result->removed);
        $this->assertFileDoesNotExist($this->path('team/paul.deadbeef.webp'));
        $this->assertFileExists($this->path('team').DIRECTORY_SEPARATOR.$tracked);
        $this->assertFileExists($this->path('team/logo.webp'));
        $this->assertFileExists($this->path('team/notes.txt'));
        $this->assertFileExists($this->path('team/paul.png'));
    }

    public function test_clean_on_a_missing_folder_does_nothing(): void
    {
        $result = $this->makeProcessor(['team' => ['width' => 300]])->clean('team');

        $this->assertSame([], $result->removed);
    }

    /**
     * The manifest is the fast path for recognising an output, not the only
     * one. Losing it must not turn a folder's own generated assets back into
     * sources, which would re-encode a re-encode on every subsequent run.
     */
    public function test_a_deleted_manifest_does_not_turn_outputs_back_into_sources(): void
    {
        $this->writeImage('team/paul.png', width: 800, height: 400);

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);
        $processor->process('team');

        $output = $this->manifest('team')['paul.png']['output'];
        unlink($this->path('team').DIRECTORY_SEPARATOR.'.qp-images-manifest.json');

        $result = $processor->process('team');

        $this->assertSame(1, $result->found);
        $this->assertSame(['paul.png'], $result->processed);
        $this->assertSame([$output, 'paul.png'], $this->files('team'));
        $this->assertSame($output, $this->manifest('team')['paul.png']['output']);
    }

    /**
     * The generated shape is matched at the configured hash length, so an
     * ordinary source that happens to carry a dotted hex-looking segment is
     * still processed rather than mistaken for an output.
     */
    public function test_a_source_with_a_hex_looking_segment_is_still_processed(): void
    {
        $this->writeImage('team/photo.2024.png');

        $result = $this->makeProcessor(['team' => ['width' => 300]])->process('team');

        $this->assertSame(['photo.2024.png'], $result->processed);
        $this->assertMatchesRegularExpression(
            '/^photo\.2024\.[0-9a-f]{8}\.webp$/',
            $this->manifest('team')['photo.2024.png']['output'],
        );
    }

    public function test_clean_leaves_a_tracked_source_alone_even_if_it_looks_generated(): void
    {
        $this->writeImage('team/photo.2024.png');

        $processor = $this->makeProcessor(['team' => ['width' => 300]]);
        $processor->process('team');

        $result = $processor->clean('team');

        $this->assertSame([], $result->removed);
        $this->assertFileExists($this->path('team/photo.2024.png'));
    }

    /**
     * A profile the resolver rejects is reported against its own folder and
     * the run carries on, so one bad config entry cannot take the folders
     * either side of it down with it.
     */
    public function test_a_malformed_profile_is_reported_without_aborting_the_run(): void
    {
        $this->writeImage('team/paul.png');
        $this->writeImage('hero/banner.png');

        $results = $this->makeProcessor([
            'team' => ['quality' => 80],
            'hero' => ['width' => 1920],
        ])->processAll();

        $this->assertSame(['hero', 'team'], array_keys($results));
        $this->assertStringContainsString('must define a positive integer width', $results['team']->error);
        $this->assertSame([], $results['team']->processed);
        $this->assertNull($results['hero']->error);
        $this->assertSame(['banner.png'], $results['hero']->processed);
    }

    /**
     * An encoder the runtime cannot use is the other folder-wide failure, and
     * it has to surface before anything is written.
     */
    public function test_an_unresolvable_format_is_reported_without_aborting_the_run(): void
    {
        $this->writeImage('team/paul.png');
        $this->writeImage('hero/banner.png');

        $results = $this->makeProcessor([
            'team' => ['width' => 300, 'format' => 'png'],
            'hero' => ['width' => 1920],
        ])->processAll();

        $this->assertStringContainsString('No encoder registered for format [png]', $results['team']->error);
        $this->assertSame([], $this->manifest('team'));
        $this->assertSame(['paul.png'], $this->files('team'));
        $this->assertSame(['banner.png'], $results['hero']->processed);
    }
}
