<?php

namespace Quepenny\Livewire\Modal;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Computed;
use Quepenny\Livewire\Modal\Contracts\CustomActions;
use Quepenny\Livewire\Traits\Makeable;

class RequireMembership extends BaseModalComponent implements CustomActions, Arrayable
{
    use Makeable;

    public bool $reloadOnClose = false;

    public ?string $transSlug = 'quepenny::modal.require-membership';

    public static function slug(): string
    {
        return 'quepenny.livewire.modal.require-membership';
    }

    public function registerCustomActions(): void
    {
        $this->setCustomAction('login', function () {
            $this->redirectRoute('login');
        });
    }

    /**
     * Redirect back to the given route after successful login.
     */
    public function redirectBackTo(string $route): static
    {
        Session::put('url.intended', $route);

        return $this;
    }

    public function confirm(): void
    {
        $this->redirectRoute('register');
    }

    public function cancel(): void
    {
        $this->reloadOnClose ? $this->redirect(URL::previous()) : $this->closeModal();
    }

    #[Computed]
    public function confirmText(): string
    {
        return $this->trans('confirm', slug: 'quepenny::modal.require-membership') ?? 'Sign Up';
    }

    #[Computed]
    public function cancelText(): string
    {
        return $this->trans('cancel', slug: 'quepenny::modal.require-membership') ?? 'Cancel';
    }

    public function toArray(): array
    {
        return [
            'transSlug' => $this->transSlug,
            'reloadOnClose' => $this->reloadOnClose,
        ];
    }
}
