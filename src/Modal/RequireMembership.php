<?php

namespace Quepenny\Livewire\Modal;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
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

    public function getBodyProperty(): string|View
    {
        return $this->message ?: parent::getBodyProperty();
    }

    public function registerCustomActions(): void
    {
        $this->setCustomAction('sign-in', function () {
            $this->redirectRoute('login');
        });
    }

    public function confirm()
    {
        $this->redirectRoute('register');
    }

    public function cancel()
    {
        $this->redirect(URL::previous());
    }
}
