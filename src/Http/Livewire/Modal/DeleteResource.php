<?php

namespace Quepenny\Livewire\Http\Livewire\Modal;

class DeleteResource extends ResourceModal
{
    public bool $destructiveAction = true;

    public function getTitleProperty(): string
    {
        return $this->trans('title', [
            'resourceName' => $this->resourceName,
            'resourceTitle' => $this->meta('title'),
        ]);
    }

    public function getSubtitleProperty(): string
    {
        return $this->trans('subtitle', [
            'resourceTitle' => $this->meta('title'),
        ]);
    }

    protected function execute(): void
    {
        $this->resource::destroy($this->resourceId);

        $this->warning(__('resources.deleted', [
            'resource' => $this->resourceName
        ]));
    }
}
