<?php

namespace Quepenny\Livewire\Http\Livewire\Modal;

use Quepenny\Livewire\Traits\Livewire\ValidatesRequests;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Laravel\Jetstream\Http\Livewire\DeleteUserForm;

class DeleteAccount extends BaseModalComponent
{
    use ValidatesRequests;

    public bool $destructiveAction = true;

    public string $password = '';

    public function getBodyProperty(): View
    {
        return view('livewire.forms.delete-account');
    }

    /**
     * @throws ValidationException
     */
    public function confirm(
        Request $request = null,
        DeletesUsers $deleter = null,
        StatefulGuard $auth = null
    ) {
        $form = new DeleteUserForm;
        $form->password = $this->password;
        $form->deleteUser($request, $deleter, $auth);
    }
}
