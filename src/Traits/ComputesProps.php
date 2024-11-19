<?php

namespace Quepenny\Livewire\Traits;

use Livewire\Attributes\Computed;
use Livewire\Exceptions\PropertyNotFoundException;
use ReflectionException;
use ReflectionMethod;

trait ComputesProps
{
    protected array $computedProps = [];

    /**
     * @throws PropertyNotFoundException|ReflectionException
     */
    public function computeProp(string $property): mixed
    {
        $methodExists = method_exists(
            $this,
            $methodName = $property
        );

        if (!$methodExists) {
            throw new PropertyNotFoundException($property, static::class);
        }

        $reflectionMethod = new ReflectionMethod($this, $methodName);
        $isComputedProp = !empty($reflectionMethod->getAttributes(Computed::class));

        if (!$isComputedProp) {
            throw new PropertyNotFoundException($property, static::class);
        }

        return $this->computedProps[$property] ??= app()->call([$this, $methodName]);
    }

    /**
     * @throws PropertyNotFoundException|ReflectionException
     */
    public function __get(string $property): mixed
    {
        return $this->computeProp($property);
    }
}
