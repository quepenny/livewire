<?php

namespace Quepenny\Livewire\Services\Images;

use InvalidArgumentException;

/**
 * Maps profile folders on disk to their resolved settings.
 *
 * A folder is only processable when its name matches a configured profile (or
 * a "default" profile is defined). Resolved settings are the configured
 * defaults merged with the profile's own overrides.
 */
class ProfileResolver
{
    /**
     * @param  string  $basePath  Absolute path to the directory holding profile folders.
     * @param  array<string, array<string, mixed>>  $profiles
     * @param  array<string, mixed>  $defaults
     */
    public function __construct(
        protected string $basePath,
        protected array $profiles = [],
        protected array $defaults = [],
    ) {}

    public function basePath(): string
    {
        return $this->basePath;
    }

    public function path(string $profile): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.$profile;
    }

    /**
     * Whether the given profile name has usable settings.
     */
    public function has(string $profile): bool
    {
        return isset($this->profiles[$profile]) || isset($this->profiles['default']);
    }

    /**
     * Resolve the effective settings for a profile, or null when the folder has
     * no matching profile and no default is configured.
     *
     * @return array<string, mixed>|null
     */
    public function resolve(string $profile): ?array
    {
        $settings = $this->profiles[$profile] ?? $this->profiles['default'] ?? null;

        if ($settings === null) {
            return null;
        }

        $resolved = array_merge($this->defaults, $settings);

        if (! isset($resolved['width']) || ! is_int($resolved['width']) || $resolved['width'] < 1) {
            throw new InvalidArgumentException("Profile [{$profile}] must define a positive integer width.");
        }

        return $resolved;
    }

    /**
     * List the profile folders that actually exist on disk and resolve to a
     * usable profile.
     *
     * @return list<string>
     */
    public function discover(): array
    {
        if (! is_dir($this->basePath)) {
            return [];
        }

        $folders = [];

        foreach (scandir($this->basePath) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $path = $this->path($entry);

            if (is_dir($path) && $this->has($entry)) {
                $folders[] = $entry;
            }
        }

        sort($folders);

        return $folders;
    }
}
