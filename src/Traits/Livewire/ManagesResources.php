<?php

namespace Quepenny\Livewire\Traits\Livewire;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Laravel\Scout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Quepenny\Livewire\Modal\Builders\DeleteResourceBuilder;
use Quepenny\Livewire\Modal\Builders\EditResourceBuilder;

/**
 * @property-read LengthAwarePaginator $resources
 * @property-read string $resourceTitle
 */
trait ManagesResources
{
    use WithPagination;
    use TriggersModals;
    use AuthorizesRequests;

    public string $search = '';

    protected int $resourcesPerPage = 15;

    protected bool $paginateResources = true;

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

    #[Computed]
    public function resources(): LengthAwarePaginator|Eloquent\Collection
    {
        return $this->paginateResources
            ? $this->fullQuery()->paginate($this->resourcesPerPage)
            : $this->fullQuery()->get();
    }

    public function create(): void
    {
        $this->modal(EditResourceBuilder::make($this->resourceClass()));
    }

    public function edit(int|string $id, string $name = ''): void
    {
        $this->modal(
            EditResourceBuilder::make($this->resourceClass(), $id)
                ->setResourceAttributes(['name' => $name])
        );
    }

    public function delete(int|string $id, string $name): void
    {
        $this->modal(DeleteResourceBuilder::make($this->resourceClass(), $id, $name));
    }

    public function resourceClass(): string
    {
        return $this->resource()::class;
    }

    #[Computed]
    public function resourceTitle(): string
    {
        return Str::of($this->resourceClass())
            ->classBasename()
            ->headline();
    }

    public function resourceText(string $key): string
    {
        return __(
            "quepenny::resources.{$key}",
            [ 'resource' => $this->resourceTitle ]
        );
    }

    protected function fullQuery(): Builder|Scout\Builder
    {
        return $this->search
            ? $this->resourcesQuery()->search($this->search)
            : $this->resourcesQuery();
    }

    protected function disableResourcePagination(): void
    {
        $this->paginateResources = false;
    }
}
