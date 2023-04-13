<?php

namespace Quepenny\Livewire\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    // ToDo: auto compute request class name for model
    private static array $modelRequestMap = [
//         Item::class => EditItemRequest::class,
//         ShoppingList::class => EditShoppingListRequest::class,
    ];

    abstract public function rules(Model|int|null $model);

    public function prepareValidationAttributes(array $attributes): array
    {
        return $attributes;
    }

    // ToDo: auto compute request class name for model
    public static function requestFor(string $model): self
    {
        $request = self::$modelRequestMap[$model];
        return new $request();
    }

    public function getStopOnFirstFailure(): bool
    {
        return $this->stopOnFirstFailure;
    }
}
