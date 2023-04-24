<?php

namespace Quepenny\Livewire\Traits\Livewire;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent;
use Laravel\Scout;
use Livewire\WithPagination;
use Quepenny\Livewire\Http\Livewire\Modal\Builders\DeleteResourceBuilder;
use Quepenny\Livewire\Http\Livewire\Modal\Builders\EditResourceBuilder;

/**
 * @property-read LengthAwarePaginator $resources
 */
trait ManagesResources
{
    use WithPagination;

    public string $search = '';

    protected int $resourcesPerPage = 15;

    public function updatedSearch($value): void
    {
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function getResourcesProperty(): LengthAwarePaginator
    {
        return $this->fullQuery()->paginate($this->resourcesPerPage);
    }

    protected function fullQuery(): Builder|Scout\Builder
    {
        return $this->search
            ? $this->resourcesQuery()->search($this->search)
            : $this->resourcesQuery();
    }

    public function edit(int $id = 0): void
    {
        $this->modal(EditResourceBuilder::make($this->resource()::class, $id));
    }

    public function delete(int $id, string $name): void
    {
        $this->modal(DeleteResourceBuilder::make($this->resource()::class, $id, $name));
    }

    abstract public function resourcesQuery(): Builder;

    abstract protected function resource(): Eloquent\Model;
}
