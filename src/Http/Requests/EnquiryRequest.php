<?php

namespace Quepenny\Livewire\Http\Requests;

use Illuminate\Database\Eloquent\Model;

class EnquiryRequest extends BaseFormRequest
{
    public function rules(Model|int|null $model): array
    {
        return [
            'subject' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
            'terms' => 'accepted',
        ];
    }
}
