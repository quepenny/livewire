<?php

namespace Quepenny\Livewire\Http\Livewire\Modal;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Quepenny\Livewire\Http\Livewire\Modal\Builders\EditResourceBuilder;
use Quepenny\Livewire\Http\Livewire\Modal\Contracts\CustomActions;
use Quepenny\Livewire\Http\Requests\BaseFormRequest;

/**
 * @property-read bool $isCreation
 * @property-read BaseFormRequest $resourceRequest
 */
class EditResource extends ResourceModal implements CustomActions
{
    use AuthorizesRequests;

    public ?string $transSlug = 'edit-resource';

    public function getResourceRequestProperty(): BaseFormRequest
    {
        return BaseFormRequest::requestFor($this->resource::class);
    }

    public function getTitleProperty(): string
    {
        return $this->trans($this->isCreation ? 'create-title' : 'edit-title', [
            'resourceName' => $this->resourceName,
            'resourceTitle' => $this->resourceTitle,
        ]);
    }

    public function getSubtitleProperty(): string
    {
        return $this->isCreation ? '' : $this->trans('edit-subtitle', [
            'resourceTitle' => $this->resourceTitle,
        ]);
    }

    public function getBodyProperty(): string|View
    {
        $form = Str::singular(str_replace('_', '-', $this->resource->getTable()));

        return view("livewire.forms.{$form}", $this->meta);
    }

    public function getConfirmTextProperty(): string
    {
        return $this->trans(
            $this->isCreation ? 'create-confirm' : 'edit-confirm'
        );
    }

    public function refreshBrowserOnConfirm(bool $value = true): static
    {
        return $this->withMeta(['refreshBrowserOnConfirm' => $value]);
    }

    public function execute(): void
    {
        $this->validateRequest($this->resourceRequest, $this->resource);
        $this->resource->save();
        $this->success(__('resources.saved', ['resource' => $this->resourceName]));
    }

    public function rules(): array
    {
        return $this->resourceRequest->rules($this->resource);
    }

    public function getIsCreationProperty(): bool
    {
        return $this->resource->getKey() === null;
    }

    public function registerCustomActions(): void
    {
        $this->isCreation && $this->setCustomAction('save-and-create-another', function () {
            $this->saveAndCreateAnother();
        });
    }

    public function saveAndCreateAnother(): void
    {
        $this->execute();

        try {
            $this->authorize('create', $this->resource::class);
            $this->modal(EditResourceBuilder::make($this->resource::class));
        } catch (AuthorizationException $e) {
            $this->modal(RequireMembership::make()->setMessage($e->getMessage()));
        }
    }
}
