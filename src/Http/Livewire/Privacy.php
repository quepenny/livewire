<?php

namespace Quepenny\Livewire\Http\Livewire;

use Quepenny\Livewire\Http\Requests\EnquiryRequest;
use Quepenny\Livewire\Mail\EnquiryMail;
use Quepenny\Livewire\Traits\Livewire\ValidatesRequests;
use Illuminate\Contracts\View\View;

class Privacy extends PageComponent
{
    public function render(): View
    {
        return view('livewire.privacy')->layoutData([
            'title' => 'Privacy',
            'nav' => ['active' => 'privacy'],
        ]);
    }
}
