<?php

namespace Quepenny\Livewire\Tests\Traits;

use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Quepenny\Livewire\Modal\Builders\BaseModalBuilder;

trait InteractsWithModals
{
    protected function testableModalBuilder(BaseModalBuilder $builder): Testable
    {
        return Livewire::test($builder->modalClass(), $builder->toArray());
    }
}
