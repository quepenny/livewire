<?php

namespace Quepenny\Livewire\Commands;

use Illuminate\Console\Command;
use Quepenny\Livewire\Services\Images\ImageProcessor;
use Quepenny\Livewire\Support\Images\ProfileResult;

class ProcessImagesCommand extends Command
{
    protected $signature = 'qp:images:process
                            {profile? : Process a single profile folder instead of all}
                            {--force : Ignore the manifest and rebuild every asset}
                            {--dry-run : Report what would happen without writing anything}';

    protected $description = 'Resize, fingerprint and encode images in public/images profile folders.';

    public function handle(ImageProcessor $processor): int
    {
        $force = (bool) $this->option('force');
        $dryRun = (bool) $this->option('dry-run');
        $profile = $this->argument('profile');

        $results = $profile
            ? [$profile => $processor->process($profile, $force, $dryRun)]
            : $processor->processAll($force, $dryRun);

        if ($results === []) {
            $this->warn('No matching profile folders found under the configured image path.');

            return self::SUCCESS;
        }

        $dryRun ? $this->reportDryRun($results) : $this->reportRun($results);

        return $this->failures($results) === 0 ? self::SUCCESS : self::FAILURE;
    }

    /**
     * @param  array<string, ProfileResult>  $results
     */
    protected function reportRun(array $results): void
    {
        foreach ($results as $profile => $result) {
            if ($result->error !== null) {
                $this->error("{$profile}: {$result->error}");

                continue;
            }

            $this->line("<info>{$profile}</info>: "
                ."processed {$result->processedCount()}, "
                ."skipped {$result->skippedCount()}, "
                .'removed '.count($result->removed).', '
                .'reclaimed '.$this->human($result->bytesSaved));

            foreach ($result->failed as $failure) {
                $this->warn("  skipped invalid image {$failure['file']}: {$failure['reason']}");
            }
        }
    }

    /**
     * @param  array<string, ProfileResult>  $results
     */
    protected function reportDryRun(array $results): void
    {
        $found = $process = $skip = $savings = 0;

        foreach ($results as $profile => $result) {
            if ($result->error !== null) {
                $this->error("{$profile}: {$result->error}");

                continue;
            }

            $found += $result->found;
            $process += $result->processedCount();
            $skip += $result->skippedCount();
            $savings += $result->bytesSaved;
        }

        $this->line('Found Images: '.$found);
        $this->line('Would Process: '.$process);
        $this->line('Would Skip: '.$skip);
        $this->line('Estimated Savings: '.$this->human($savings));
    }

    /**
     * A folder that could not be processed at all counts against the exit code
     * just as an unreadable image does, so a broken profile still fails a
     * deploy rather than passing quietly.
     *
     * @param  array<string, ProfileResult>  $results
     */
    protected function failures(array $results): int
    {
        return array_sum(array_map(
            fn (ProfileResult $r) => count($r->failed) + ($r->error === null ? 0 : 1),
            $results,
        ));
    }

    protected function human(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $bytes > 0 ? (int) floor(log($bytes, 1024)) : 0;
        $power = min($power, count($units) - 1);

        return round($bytes / (1024 ** $power), 1).' '.$units[$power];
    }
}
