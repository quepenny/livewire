<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;
use Quepenny\Livewire\Http\Requests\EnquiryRequest;
use Quepenny\Livewire\Traits\Livewire\ValidatesRequests;

class Enquiry extends PageComponent
{
    use ValidatesRequests;

    public string $name = '';

    public string $email = '';

    public string $subject = '';

    public string $message = '';

    public bool $terms = false;

    public function submit()
    {
        $this->validateRequest(new EnquiryRequest);

//        return new EnquiryMail(request());
    }

    public function render(): View
    {
        return view('livewire.enquiry')->layoutData([
            'title' => 'Contact',
            'nav' => ['active' => 'contact'],
        ]);
    }
}
