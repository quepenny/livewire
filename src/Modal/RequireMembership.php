<?php

namespace Quepenny\Livewire\Modal;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Computed;
use Quepenny\Livewire\Modal\Contracts\CustomActions;
use Quepenny\Livewire\Traits\Makeable;

class RequireMembership extends BaseModalComponent implements CustomActions, Arrayable
{
    use Makeable;

    public string $message = '';

    public function setMessage(string $key): static
    {
        $this->message = $key;

        return $this;
    }

    public function toArray(): array
    {
        return ['message' => $this->message];
    }

    #[Computed]
    public function body(): string|View
    {
        return $this->message ?: parent::body();
    }

    public function registerCustomActions(): void
    {
        $this->setCustomAction('sign-in', function () {
            $this->redirectRoute('login');
        });
    }

    public function confirm(): void
    {
        $this->redirectRoute('register');
    }

    public function cancel(): void
    {
        $this->redirect(URL::previous());
    }
}
