<?php

namespace Quepenny\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Quepenny\Livewire\Forms\EnquiryForm;
use Quepenny\Livewire\Notifications\EnquirySubmitted;

class Enquiry extends PageComponent
{
    public EnquiryForm $form;

    public bool $submitted = false;

    public function submit(): void
    {
        $enquiry = $this->form->store();
        $enquiry->notify(new EnquirySubmitted);
        $this->submitted = true;
    }

    #[Layout('components.layouts.form-page')]
    public function render(): View
    {
        return view('livewire.enquiry')->layoutData([
            'title' => __('pages.contact.title') ?: 'Contact ',
            'nav' => ['active' => 'contact'],
            'mainTitle' => __('quepenny::enquiry.title'),
            'subTitle' => __('quepenny::enquiry.subtitle'),
            'buttonText' => __('Contact'),
        ]);
    }
}
