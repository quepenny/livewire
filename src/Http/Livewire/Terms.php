<?php

namespace Quepenny\Livewire\Http\Livewire;

use Quepenny\Livewire\Http\Requests\EnquiryRequest;
use Quepenny\Livewire\Mail\EnquiryMail;
use Quepenny\Livewire\Traits\Livewire\ValidatesRequests;
use Illuminate\Contracts\View\View;

class Terms extends PageComponent
{
    public function render(): View
    {
        return view('livewire.terms')->layoutData([
            'title' => 'Terms of Service',
            'nav' => ['active' => 'terms'],
        ]);
    }
}
