<?php

namespace Quepenny\Livewire\Http\Livewire;

use Quepenny\Livewire\Http\Requests\EnquiryRequest;
use Quepenny\Livewire\Mail\EnquiryMail;
use Quepenny\Livewire\Traits\Livewire\ValidatesRequests;
use Illuminate\Contracts\View\View;

class Cookies extends PageComponent
{
    public function render(): View
    {
        return view('livewire.cookies')->layoutData([
            'title' => 'Cookie Policy',
            'nav' => ['active' => 'cookies'],
        ]);
    }
}
