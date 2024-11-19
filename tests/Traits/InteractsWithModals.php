<?php

namespace Quepenny\Livewire\Tests\Traits;

use Livewire\Livewire;
use Quepenny\Livewire\Modal\Builders\BaseModalBuilder;

trait InteractsWithModals
{
    protected function testableModalBuilder(BaseModalBuilder $builder): void
    {
        return Livewire::test(
            $builder->slug(),
            $builder->toArray()
        );
    }
}
