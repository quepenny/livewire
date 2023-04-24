<?php

namespace Quepenny\Livewire\Traits\Livewire;

use Illuminate\Database\Eloquent\Model;
use Quepenny\Livewire\Http\Requests\BaseFormRequest;

trait ValidatesRequests
{
    private BaseFormRequest $validationRequest;

    protected function validateRequest(
        BaseFormRequest $request,
        Model|int|null $model = null
    ): array {
        $this->validationRequest = $request;

        return $this->validate(
            $this->validationRequest->rules($model),
            $this->validationRequest->messages(),
            $this->validationRequest->attributes(),
            $request->getStopOnFirstFailure()
        );
    }

    protected function prepareForValidation($attributes): array
    {
        return $this->validationRequest->prepareValidationAttributes($attributes);
    }
}
