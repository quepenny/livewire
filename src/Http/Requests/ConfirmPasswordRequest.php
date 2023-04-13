<?php

namespace Quepenny\Livewire\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConfirmPasswordRequest extends BaseFormRequest
{
    public function rules(Model|int|null $model = null): array
    {
        return [
            'password' => ['required', function ($attr, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail(__('This password is invalid.'));
                }
            }]
        ];
    }
}
