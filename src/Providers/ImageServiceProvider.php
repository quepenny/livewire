<?php

namespace Quepenny\Livewire\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Quepenny\Livewire\Commands\CleanImagesCommand;
use Quepenny\Livewire\Commands\ProcessImagesCommand;
use Quepenny\Livewire\Services\Images\Encoders\EncoderManager;
use Quepenny\Livewire\Services\Images\HashGenerator;
use Quepenny\Livewire\Services\Images\ImageProcessor;
use Quepenny\Livewire\Services\Images\ImageUrlResolver;
use Quepenny\Livewire\Services\Images\ManifestManager;
use Quepenny\Livewire\Services\Images\ProfileResolver;

class ImageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/quepenny-images.php', 'quepenny-images');

        $this->app->singleton(ImageManager::class, fn () => new ImageManager(new Driver));

        $this->app->singleton(EncoderManager::class, fn ($app) => new EncoderManager(
            $app['config']->get('quepenny-images.encoders', []),
        ));

        $this->app->singleton(HashGenerator::class, fn ($app) => new HashGenerator(
            (int) $app['config']->get('quepenny-images.hash_length', 8),
        ));

        $this->app->singleton(ManifestManager::class, fn ($app) => new ManifestManager(
            $app['config']->get('quepenny-images.manifest', '.qp-images-manifest.json'),
        ));

        $this->app->singleton(ProfileResolver::class, fn ($app) => new ProfileResolver(
            $this->basePath(),
            $app['config']->get('quepenny-images.profiles', []),
            $app['config']->get('quepenny-images.defaults', []),
        ));

        $this->app->singleton(ImageUrlResolver::class, fn ($app) => new ImageUrlResolver(
            $this->basePath(),
            $app['config']->get('quepenny-images.public_url', '/images'),
            $app->make(ManifestManager::class),
        ));

        $this->app->singleton(ImageProcessor::class, fn ($app) => new ImageProcessor(
            $app->make(ImageManager::class),
            $app->make(EncoderManager::class),
            $app->make(ProfileResolver::class),
            $app->make(ManifestManager::class),
            $app->make(HashGenerator::class),
            $app['config']->get('quepenny-images.source_formats', ['jpg', 'jpeg', 'png', 'gif', 'webp']),
        ));
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/quepenny-images.php' => config_path('quepenny-images.php'),
        ], ['quepenny', 'config', 'quepenny-images']);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ProcessImagesCommand::class,
                CleanImagesCommand::class,
            ]);
        }

        Blade::directive('qpImage', function (string $expression) {
            return "<?php echo e(qp_image({$expression})); ?>";
        });
    }

    /**
     * Absolute path to the directory holding profile folders.
     */
    protected function basePath(): string
    {
        return public_path((string) $this->app['config']->get('quepenny-images.base_path', 'images'));
    }
}
