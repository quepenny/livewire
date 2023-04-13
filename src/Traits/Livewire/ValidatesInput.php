<?php

namespace Quepenny\Livewire\Traits\Livewire;

use Illuminate\Support\Facades\Validator;

trait ValidatesInput
{
    public function validate(
        $rules = null,
        $messages = [],
        $attributes = [],
        bool $stopOnFirstFailure = false
    ): array {
        [$rules, $messages, $attributes] = $this->providedOrGlobalRulesMessagesAndAttributes($rules, $messages, $attributes);

        $data = $this->prepareForValidation(
            $this->getDataForValidation($rules)
        );

        $ruleKeysToShorten = $this->getModelAttributeRuleKeysToShorten($data, $rules);

        $data = $this->unwrapDataForValidation($data);

        $validator = Validator::make($data, $rules, $messages, $attributes);

        $stopOnFirstFailure && $validator->stopOnFirstFailure();

        if ($this->withValidatorCallback) {
            call_user_func($this->withValidatorCallback, $validator);

            $this->withValidatorCallback = null;
        }

        $this->shortenModelAttributesInsideValidator($ruleKeysToShorten, $validator);

        $validatedData = $validator->validate();

        $this->resetErrorBag();

        return $validatedData;
    }
}
