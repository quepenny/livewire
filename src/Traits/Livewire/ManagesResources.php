<?php

namespace Quepenny\Livewire\Traits\Livewire;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laravel\Scout;
use Livewire\WithPagination;
use Quepenny\Livewire\Modal\Builders\DeleteResourceBuilder;
use Quepenny\Livewire\Modal\Builders\EditResourceBuilder;
use Quepenny\Livewire\Modal\RequireMembership;

/**
 * @property-read LengthAwarePaginator $resources
 */
trait ManagesResources
{
    use WithPagination;
    use TriggersModals;
    use AuthorizesRequests;

    public string $search = '';

    protected int $resourcesPerPage = 15;

    abstract public function resourcesQuery(): Builder;

    abstract protected function resource(): Eloquent\Model;

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

    public function create(): void
    {
        try {
            $this->authorize('create', $this->resourceClass());
            $this->modal(EditResourceBuilder::make($this->resourceClass()));
        } catch (AuthorizationException) {
            $this->modal(new RequireMembership);
        }
    }

    public function edit(int $id, string $name = ''): void
    {
        $this->authorize('view', $this->resourceClass());

        $this->modal(
            EditResourceBuilder::make($this->resourceClass(), $id)
                ->setResourceAttributes(['name' => $name])
        );
    }

    public function delete(int $id, string $name): void
    {
        $this->modal(DeleteResourceBuilder::make($this->resourceClass(), $id, $name));
    }

    public function resourceClass(): string
    {
        return $this->resource()::class;
    }
}
