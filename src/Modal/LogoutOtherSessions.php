<?php

namespace Quepenny\Livewire\Modal;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Http\Livewire\LogoutOtherBrowserSessionsForm;
use Livewire\Attributes\Computed;

class LogoutOtherSessions extends BaseModalComponent
{
    public string $password = '';

    public bool $destructiveAction = true;

    #[Computed]
    public function body(): View
    {
        return view('livewire.forms.logout-other-sessions');
    }

    /**
     * @throws ValidationException
     */
    public function confirm(StatefulGuard $guard = null): void
    {
        $form = new LogoutOtherBrowserSessionsForm;
        $form->password = $this->password;
        $form->logoutOtherBrowserSessions($guard);
        $this->redirect(route('login'));
    }
}
