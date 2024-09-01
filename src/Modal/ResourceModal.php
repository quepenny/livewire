<?php

namespace Quepenny\Livewire\Modal;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Quepenny\Livewire\Traits\Livewire\TriggersModals;
use Quepenny\Livewire\Traits\Metable;

abstract class ResourceModal extends BaseModalComponent
{
    use Metable;
    use TriggersModals;

    public ?Model $resource = null;

    public int $resourceId;

    public string $resourceTitle;

    public string $resourceName;

    public function mount(string $model, array $attributes = [], array $meta = []): void
    {
        $this->resourceId = Arr::get($attributes, 'id') ?? 0;
        $this->resourceName = Str::space(class_basename($model));
        $this->withMeta($meta);
        $this->setResource($model, $attributes);
        $this->setResourceTitle();
    }

    protected function setResource(string $model, array $attributes): void
    {
        if ($this->meta('lazyLoadResource') || ! $this->resourceId) {
            $this->resource = new $model($attributes);
        } else {
            $this->resource = $model::find($this->resourceId);
        }
    }

    protected function setResourceTitle(): void
    {
        $this->resourceTitle = $this->meta('title') ?? '';

        if (! $this->resourceTitle && $this->resourceId) {
            $titleAttribute = $this->meta('titleAttribute');
            $this->resourceTitle = $this->resource->{$titleAttribute};
        }
    }

    public function setBody(string $key): static
    {
        return $this->withMeta(['bodyKey' => $key]);
    }

    #[Computed]
    public function body(): string|View
    {
        return $this->trans($this->meta('bodyKey') ?? 'body');
    }

    final public function confirm(): void
    {
        $this->execute();

        if ($this->meta('refreshBrowserOnConfirm')) {
            $this->redirect(URL::previous());
        } else {
            $this->forceClose()->closeModalWithEvents(['$refresh']);
        }
    }

    public function cancel(): void
    {
        $this->forceClose()->closeModalWithEvents(['$refresh']);
    }

    abstract protected function execute(): void;
}
