<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
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
    #[Layout('components.layouts.form-page')]
    public function render(): View
    {
        return view('livewire.enquiry')->layoutData([
            'nav' => ['active' => 'contact'],
            'mainTitle' => __('quepenny::enquiry.title'),
            'subTitle' => __('quepenny::enquiry.subtitle'),
            'buttonText' => __('Contact'),
            'formAction' => route('contact'),
        ]);
    }
}
