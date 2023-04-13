<?php

namespace Quepenny\Livewire\Traits;

use Livewire\Exceptions\PropertyNotFoundException;

trait ComputesProps
{
    protected array $computedProps = [];

    /**
     * @throws PropertyNotFoundException
     */
    public function prop(string $prop): mixed
    {
        $studlyProperty = str_replace(
            ' ', '', ucwords(str_replace(['-', '_'], ' ', $prop))
        );

        $methodExists = method_exists(
            $this,
            $methodName = 'get' . $studlyProperty . 'Property'
        );

        if ($methodExists) {
            if (isset($this->computedProps[$prop])) {
                return $this->computedProps[$prop];
            }

            return $this->computedProps[$prop] = app()->call([$this, $methodName]);
        }

        throw new PropertyNotFoundException($prop, static::class);
    }

    /**
     * @throws PropertyNotFoundException
     */
    public function __get(string $prop): mixed
    {
        return $this->prop($prop);
    }
}
