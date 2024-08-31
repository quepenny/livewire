<?php

namespace Quepenny\Livewire\Providers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Scout\Builder;
use Livewire\Features\SupportTesting\Testable;
use PHPUnit\Framework\Assert as PHPUnit;
use Quepenny\Livewire\Modal\BaseModalComponent;
use Quepenny\Livewire\Modal\Builders\BaseModalBuilder;

class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->scout();
        $this->string();
        $this->livewireTestable();
    }

    private function string(): void
    {
        Str::macro('space', function (string $text) {
            if (! ctype_lower($text)) {
                $text = preg_replace('/\s+/u', '', ucwords($text));
                $text = preg_replace('/(.)(?=[A-Z])/u', '$1 ', $text);
            }

            return $text;
        });
    }

    private function scout(): void
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

    private function livewireTestable(): void
    {
        Testable::macro('assertModalDispatched', function (BaseModalComponent|BaseModalBuilder $modal, $params = []) {
            $eventParams = [
                'component' => $modal::slug(),
                'arguments' => $modal instanceof Arrayable ? $modal->toArray() : $params,
            ];

            PHPUnit::assertTrue(
                $this->testDispatched('openModal', $eventParams)['test'],
                "Failed asserting that {$modal::slug()} was dispatched with the provided parameters."
            );

            PHPUnit::assertSame(
                Session::get('open-modal'),
                $eventParams,
                "Failed asserting that {$modal::slug()} was dispatched using a session variable."
            );

            return $this;
        });
    }
}
