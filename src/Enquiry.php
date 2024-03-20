<?php

namespace Quepenny\Livewire;

use Quepenny\Livewire\Forms\EnquiryForm;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Enquiry extends PageComponent
{
    public EnquiryForm $form;

    public bool $submitted = false;

    public function submit(): void
    {
        $this->form->store();
        $this->form->notify();
        $this->submitted = true;
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
        ]);
    }
}
