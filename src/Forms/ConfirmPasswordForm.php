<?php

namespace Quepenny\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Form;

class ConfirmPasswordForm extends Form
{
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                function ($attr, $value, $fail) {
                    if (! Hash::check($value, Auth::user()->password)) {
                        $fail(__('This password is invalid.'));
                    }
                }
            ],
        ];
    }
}
