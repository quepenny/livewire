<?php

namespace Quepenny\Livewire\Modal;

use Livewire\Attributes\Computed;

class DeleteResource extends ResourceModal
{
    public bool $destructiveAction = true;

    public ?string $transSlug = 'quepenny::modal.delete-resource';

    public static function slug(): string
    {
        return 'quepenny::livewire.modal.delete-resource';
    }

    #[Computed]
    public function title(): string
    {
        return $this->trans('title', [
            'resourceName' => $this->resourceName,
            'resourceTitle' => $this->meta('title'),
        ]);
    }

    #[Computed]
    public function subtitle(): string
    {
        return $this->trans('subtitle', [
            'resourceTitle' => $this->meta('title'),
        ]);
    }

    protected function execute(): void
    {
        $this->resource::destroy($this->resourceId);

        $this->success(__('quepenny::resources.resource_deleted', [
            'resource' => $this->resourceName,
        ]));
    }
}
