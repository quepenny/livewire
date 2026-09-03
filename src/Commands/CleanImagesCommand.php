<?php

namespace Quepenny\Livewire\Commands;

use Illuminate\Console\Command;
use Quepenny\Livewire\Services\Images\ImageProcessor;
use Quepenny\Livewire\Services\Images\ProfileResolver;

class CleanImagesCommand extends Command
{
    protected $signature = 'qp:images:clean
                            {profile? : Clean a single profile folder instead of all}';

    protected $description = 'Remove orphaned generated images no longer referenced by a manifest.';

    public function handle(ImageProcessor $processor, ProfileResolver $profiles): int
    {
        $profile = $this->argument('profile');
        $targets = $profile ? [$profile] : $profiles->discover();

        if ($targets === []) {
            $this->warn('No matching profile folders found under the configured image path.');

            return self::SUCCESS;
        }

        $total = 0;

        foreach ($targets as $target) {
            $result = $processor->clean($target);
            $total += count($result->removed);

            $this->line("<info>{$target}</info>: removed ".count($result->removed).' orphaned file(s).');

            foreach ($result->removed as $file) {
                $this->line("  - {$file}");
            }
        }

        $this->info("Done. {$total} file(s) removed.");

        return self::SUCCESS;
    }
}
