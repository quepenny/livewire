<?php

namespace Quepenny\Livewire\Support\Images;

/**
 * Aggregated outcome of processing a single profile folder.
 *
 * Doubles as the reporting payload for the console commands, including the
 * dry-run summary (found / would-process / would-skip / estimated savings).
 */
class ProfileResult
{
    /** @var list<string> */
    public array $processed = [];

    /** @var list<string> */
    public array $skipped = [];

    /** @var list<array{file: string, reason: string}> */
    public array $failed = [];

    /** @var list<string> */
    public array $removed = [];

    /** Total bytes reclaimed (originals + obsolete outputs replaced by smaller assets). */
    public int $bytesSaved = 0;

    /** Number of source images discovered in the folder. */
    public int $found = 0;

    /**
     * Why the folder could not be processed at all - a malformed profile, or a
     * format this runtime has no usable encoder for. Distinct from a failed
     * file: nothing in the folder was looked at.
     */
    public ?string $error = null;

    public function __construct(public string $profile) {}

    public function markProcessed(string $file, int $bytesSaved = 0): void
    {
        $this->processed[] = $file;
        $this->bytesSaved += $bytesSaved;
    }

    public function markSkipped(string $file): void
    {
        $this->skipped[] = $file;
    }

    public function markFailed(string $file, string $reason): void
    {
        $this->failed[] = compact('file', 'reason');
    }

    public function markUnprocessable(string $reason): void
    {
        $this->error = $reason;
    }

    public function markRemoved(string $file, int $bytes = 0): void
    {
        $this->removed[] = $file;
        $this->bytesSaved += $bytes;
    }

    public function processedCount(): int
    {
        return count($this->processed);
    }

    public function skippedCount(): int
    {
        return count($this->skipped);
    }
}
