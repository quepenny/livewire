<?php

namespace Quepenny\Livewire\Traits\Models;

use Illuminate\Support\Arr;

trait HasRelationships
{
    public function loadMissingCount(string|array $relations): static
    {
        $missingRelationCounts = [];

        foreach (Arr::wrap($relations) as $relation => $constraints) {
            if (is_numeric($relation)) {
                $relation = $constraints;
            }

            $alias = $relation;

            if (str_contains(strtolower($relation), ' as ')) {
                $alias = preg_split('/\s+as\s+/i', $relation)[1];
            }

            if (! array_key_exists("{$alias}_count", $this->getAttributes())) {
                $missingRelationCounts[$relation] = $constraints;
            }
        }

        return $this->loadCount($missingRelationCounts);
    }
}
