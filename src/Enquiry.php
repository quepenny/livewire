<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Quepenny\Livewire\Http\Requests\EnquiryRequest;

class Enquiry extends PageComponent
{
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

    #[Title('Contact')]
    public function render(): View
    {
        return view('livewire.enquiry')->with([
            'nav' => ['active' => 'contact'],
        ]);
    }
}
