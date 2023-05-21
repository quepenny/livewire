<?php

namespace Quepenny\Livewire\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    abstract public function rules(Model|int|null $model);

    public function prepareValidationAttributes(array $attributes): array
    {
        return $attributes;
    }

    public static function requestFor(Model|string $model): self
    {
        $modelClass = class_basename($model);
        $requestClass = "\\App\\Http\\Requests\\Edit{$modelClass}Request";

        return new $requestClass();
    }

    public function getStopOnFirstFailure(): bool
    {
        return $this->stopOnFirstFailure;
    }
}
