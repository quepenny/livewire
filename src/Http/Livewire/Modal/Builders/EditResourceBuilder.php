<?php

namespace Quepenny\Livewire\Http\Livewire\Modal\Builders;

use Quepenny\Livewire\Traits\ComputesProps;
use Quepenny\Livewire\Traits\Metable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * @property-read bool $isCreation
 */
class EditResourceBuilder extends BaseModalBuilder implements Arrayable
{
    use ComputesProps;
    use Metable;

    public string $resourceClass;
    public array $resourceAttributes = [];

    public function __construct(
        string $model,
        int $id = 0,
        string $title = ''
    ) {
        $this->resourceClass = $model;
        $this->resourceAttributes['id'] = $id;

        $this->withMeta([
            'title' => $title,
            'titleAttribute' => 'name',
        ]);
    }

    public function setResourceAttributes(array $attributes): static
    {
        $this->resourceAttributes = array_merge($this->resourceAttributes, $attributes);
        return $this;
    }

    public function setTitleAttribute(string $attribute): static
    {
        return $this->withMeta(['titleAttribute' => $attribute]);
    }

    public function lazyLoadResource(): static
    {
        return $this->withMeta(['lazyLoadResource' => true]);
    }

    public function refreshBrowserOnConfirm(bool $value = true): static
    {
        return $this->withMeta(['refreshBrowserOnConfirm' => $value]);
    }

    public function setBody(string $key): static
    {
        return $this->withMeta(['bodyKey' => $key]);
    }

    public function getIsCreationProperty(): bool
    {
        return !$this->resourceAttributes['id'];
    }

    public function toArray(): array
    {
        return [
            'model' => $this->resourceClass,
            'attributes' => $this->resourceAttributes,
            'meta' => $this->meta(),
            // Unique modal ID for "save & create another"
            // Child modal won't spawn if having same exact params as parent
            'modalId' => $this->isCreation ? Str::ulid() : null
        ];
    }
}
