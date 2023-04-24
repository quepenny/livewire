<?php

namespace Quepenny\Livewire\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Str;
use Laravel\Scout\Builder;
use Quepenny\Livewire\Listeners\TransferGuestDataOnLogin;
use App\Models\Guest;
use App\Models\User;

class QuepennyServiceProvider extends EventServiceProvider
{
    protected $listen = [
        Login::class => [
            TransferGuestDataOnLogin::class,
        ],
    ];

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'quepenny');

        $this->publishes([
            __DIR__.'/../../src/Models' => app_path('Models'),
        ], 'models');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../.gitignore' => base_path('.gitignore'),
            __DIR__.'/../../deploy.sh' => base_path('deploy.sh'),
            __DIR__.'/../../package.json' => base_path('package.json'),
            __DIR__.'/../../tailwind.config.js' => base_path('tailwind.config.js'),
            __DIR__.'/../../webpack.mix.js' => base_path('webpack.mix.js'),
        ], 'setup');

        $this->publishes([
            __DIR__.'/../../public/icon' => public_path('icon'),
            __DIR__.'/../../public/.htaccess' => public_path('.htaccess'),
        ], 'public');

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
