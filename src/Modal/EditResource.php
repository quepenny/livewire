<?php

namespace Quepenny\Livewire\Modal;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Form;
use Quepenny\Livewire\Modal\Builders\EditResourceBuilder;
use Quepenny\Livewire\Modal\Contracts\CustomActions;

/**
 * @property-read bool $isCreation
 * @property-read Form $resourceForm
 */
class EditResource extends ResourceModal implements CustomActions
{
    use AuthorizesRequests;

    public ?string $transSlug = 'quepenny::modal.edit-resource';

    public Form $form;

    public function mount(string $model, array $attributes = [], array $meta = []): void
    {
        parent::mount($model, $attributes, $meta);

        // Initialize resource form
        $this->form = $this->resourceForm;
        $this->form->fill($attributes);
    }

    public static function slug(): string
    {
        return 'quepenny::livewire.modal.edit-resource';
    }

    #[Computed]
    public function title(): string
    {
        return $this->trans($this->isCreation ? 'create-title' : 'edit-title', [
            'resourceName' => $this->resourceName,
            'resourceTitle' => $this->resourceTitle,
        ]);
    }

    #[Computed]
    public function subtitle(): string
    {
        return $this->isCreation ? '' : $this->trans('edit-subtitle', [
            'resourceTitle' => $this->resourceTitle,
        ]);
    }

    #[Computed]
    public function body(): string|View
    {
        $form = Str::singular(str_replace('_', '-', $this->resource->getTable()));

        return view("livewire.forms.{$form}", $this->meta);
    }

    #[Computed]
    public function confirmText(): string
    {
        return $this->trans(
            $this->isCreation ? 'create-confirm' : 'edit-confirm'
        );
    }

    #[Computed]
    public function resourceForm(): Form
    {
        $modelClass = class_basename($this->resource);
        $formClass = "\\App\\Livewire\\Forms\\Edit{$modelClass}Form";

        return new $formClass($this, 'form');
    }

    public function refreshBrowserOnConfirm(bool $value = true): static
    {
        return $this->withMeta(['refreshBrowserOnConfirm' => $value]);
    }

    public function execute(): void
    {
        $this->form->validate();

        $this
            ->resource
            ->fill($this->form->all())
            ->save();

        $this->success(__('quepenny::resources.saved', ['resource' => $this->resourceName]));
    }

    #[Computed]
    public function isCreation(): bool
    {
        return !$this->resource->getKey();
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
        } catch (AuthorizationException) {
            $this->modal(RequireMembership::make());
        }
    }
}
