<?php

namespace Quepenny\Livewire\Providers;

use Quepenny\Livewire\Listeners\TransferGuestDataOnLogin;
use Quepenny\Livewire\Models\Guest;
use Quepenny\Livewire\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Str;
use Laravel\Scout\Builder;

class QuepennyServiceProvider extends EventServiceProvider
{
    protected $listen = [
        Login::class => [
            TransferGuestDataOnLogin::class,
        ]
    ];

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../views', 'quepenny');

        $this->morphMap();
        $this->macros();
    }

    private function morphMap(): void
    {
        Relation::enforceMorphMap([
            'member' => User::class,
            'guest' => Guest::class,
        ]);
    }

    private function macros(): void
    {
        $this->scoutMacros();
        $this->stringMacros();
    }

    private function stringMacros(): void
    {
        Str::macro('space', function (string $text) {
            if (!ctype_lower($text)) {
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
