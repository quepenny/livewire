<?php

namespace Quepenny\Livewire\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Scout\Builder;

class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->scoutMacros();
        $this->stringMacros();
    }

    private function stringMacros(): void
    {
        Str::macro('space', function (string $text) {
            if (! ctype_lower($text)) {
                $text = preg_replace('/\s+/u', '', ucwords($text));
                $text = preg_replace('/(.)(?=[A-Z])/u', '$1 ', $text);
            }

            return $text;
        });
    }

    private function scoutMacros(): void
    {
        Builder::macro('buildQuery', function (callable $callback) {
            if (is_callable($this->queryCallback)) {
                $queryCallback = $this->queryCallback;

                $this->queryCallback = function ($builder) use ($queryCallback, $callback) {
                    $queryCallback($builder);
                    $callback($builder);
                };
            } else {
                $this->queryCallback = $callback;
            }

            return $this;
        });
    }
}
