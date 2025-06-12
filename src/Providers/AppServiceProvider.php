<?php

namespace Quepenny\Livewire\Providers;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Quepenny\Livewire\Cookies;
use Quepenny\Livewire\Enquiry;
use Quepenny\Livewire\Modal\DeleteAccount;
use Quepenny\Livewire\Modal\DeleteResource;
use Quepenny\Livewire\Modal\EditResource;
use Quepenny\Livewire\Modal\LogoutOtherSessions;
use Quepenny\Livewire\Modal\RequireMembership;
use Quepenny\Livewire\Privacy;
use Quepenny\Livewire\Terms;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'quepenny');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->morphMap();
        $this->publishAssets();
        $this->registerLivewireComponents();
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
        ], ['quepenny', 'assets']);

        $this->publishes([
            __DIR__.'/../../config/livewire.php' => config_path('livewire.php'),
            __DIR__.'/../../config/quepenny.php' => config_path('quepenny.php'),
        ], ['quepenny', 'config']);

        $this->publishes([
            __DIR__.'/../../lang/en/empty.php' => lang_path('en/empty.php'),
            __DIR__.'/../../lang/en/legal.php' => lang_path('en/legal.php'),
        ], ['quepenny', 'lang']);

        $this->publishes([
            __DIR__.'/../../src/Models/Guest.php' => app_path('Models/Guest.php'),
            __DIR__.'/../../src/Traits/Models/UserTrait.php' => app_path('Traits/Models/UserTrait.php'),
        ], ['quepenny', 'models']);

        $this->publishes([
            __DIR__.'/../../resources/css' => resource_path('css'),
            __DIR__.'/../../resources/js' => resource_path('js'),
            __DIR__.'/../../resources/views' => resource_path('views'),
        ], ['quepenny', 'resources']);

        $this->publishes([
            __DIR__.'/../../.gitignore' => base_path('.gitignore'),
            __DIR__.'/../../docker-compose.yml' => base_path('docker-compose.yml'),
            __DIR__.'/../../package.json' => base_path('package.json'),
            __DIR__.'/../../phpunit.xml' => base_path('phpunit.xml'),
            __DIR__.'/../../postcss.config.js' => base_path('postcss.config.js'),
            __DIR__.'/../../tailwind.config.js' => base_path('tailwind.config.js'),
            __DIR__.'/../../vite.config.js' => base_path('vite.config.js'),
            __DIR__.'/../../.phpstorm.meta.php' => base_path('.phpstorm.meta.php'),
        ], ['quepenny', 'setup']);

        $this->publishes([
            __DIR__.'/../../src/View/Components/AppLayout.php' => app_path('View/Components/AppLayout.php'),
            __DIR__.'/../../src/View/Components/Input.php' => app_path('View/Components/Input.php'),
            __DIR__.'/../../src/View/Components/Tooltip.php' => app_path('View/Components/Tooltip.php'),
        ], ['quepenny', 'components']);
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('quepenny::livewire.cookies', Cookies::class);
        Livewire::component('quepenny::livewire.contact', Enquiry::class);
        Livewire::component('quepenny::livewire.privacy', Privacy::class);
        Livewire::component('quepenny::livewire.terms', Terms::class);
        Livewire::component('quepenny::livewire.modal.edit-resource', EditResource::class);
        Livewire::component('quepenny::livewire.modal.delete-resource', DeleteResource::class);
        Livewire::component('quepenny::livewire.modal.logout-other-sessions', LogoutOtherSessions::class);
        Livewire::component('quepenny::livewire.modal.delete-account', DeleteAccount::class);
        Livewire::component('quepenny::livewire.modal.require-membership', RequireMembership::class);
    }
}
