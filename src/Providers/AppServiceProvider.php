<?php

namespace Quepenny\Livewire\Providers;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'quepenny');
        $this->morphMap();
        $this->publishAssets();
    }

    private function morphMap(): void
    {
        Relation::enforceMorphMap([
            'member' => User::class,
            'guest' => Guest::class,
        ]);
    }

    private function publishAssets(): void
    {
        $this->publishes([
            __DIR__.'/../../database/migrations/2014_10_12_200000_add_two_factor_columns_to_users_table.php' => database_path('migrations/2014_10_12_200000_add_two_factor_columns_to_users_table.php'),
        ], 'database');

        $this->publishes([
            __DIR__.'/../../src/Models/Guest.php' => app_path('Models/Guest.php'),
            __DIR__.'/../../src/Traits/Models/UserTrait.php' => app_path('Traits/Models/UserTrait.php'),
        ], 'models');

        $this->publishes([
            __DIR__.'/../../resources/css' => resource_path('css'),
            __DIR__.'/../../resources/js' => resource_path('js'),
            __DIR__.'/../../resources/views' => resource_path('views'),
        ], 'resources');

        $this->publishes([
            __DIR__.'/../../.env' => base_path('.env'),
            __DIR__.'/../../.gitignore' => base_path('.gitignore'),
            __DIR__.'/../../deploy.sh' => base_path('deploy.sh'),
            __DIR__.'/../../package.json' => base_path('package.json'),
            __DIR__.'/../../tailwind.config.js' => base_path('tailwind.config.js'),
            __DIR__.'/../../webpack.mix.js' => base_path('webpack.mix.js'),
            __DIR__.'/../../phpunit.xml' => base_path('phpunit.xml'),
        ], 'setup');

        $this->publishes([
            __DIR__.'/../../public/icon' => public_path('icon'),
            __DIR__.'/../../public/.htaccess' => public_path('.htaccess'),
        ], 'assets');
    }
}
