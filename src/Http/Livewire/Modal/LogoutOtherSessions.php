<?php

namespace Quepenny\Livewire\Http\Livewire\Modal;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Http\Livewire\LogoutOtherBrowserSessionsForm;
use Quepenny\Livewire\Traits\Livewire\ValidatesRequests;

class LogoutOtherSessions extends BaseModalComponent
{
    use ValidatesRequests;

    public string $password = '';

    public bool $destructiveAction = true;

    public function getBodyProperty(): View
    {
        return view('livewire.forms.logout-other-sessions');
    }

    /**
     * @throws ValidationException
     */
    public function confirm(StatefulGuard $guard = null)
    {
        $form = new LogoutOtherBrowserSessionsForm;
        $form->password = $this->password;
        $form->logoutOtherBrowserSessions($guard);
        $this->redirect(route('login'));
    }
}
