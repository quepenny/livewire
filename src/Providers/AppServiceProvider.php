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
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
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
            __DIR__.'/../../public/icon' => public_path('icon'),
            __DIR__.'/../../public/.htaccess' => public_path('.htaccess'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/../../config/jetstream.php' => config_path('jetstream.php'),
            __DIR__.'/../../config/livewire.php' => config_path('livewire.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../lang/en/empty.php' => lang_path('en/empty.php'),
        ], 'lang');

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
            __DIR__.'/../../src/View/Components/AppLayout.php' => app_path('View/Components/AppLayout.php'),
            __DIR__.'/../../src/View/Components/Input.php' => app_path('View/Components/Input.php'),
            __DIR__.'/../../src/View/Components/Tooltip.php' => app_path('View/Components/Tooltip.php'),
        ], 'components');
    }
}
