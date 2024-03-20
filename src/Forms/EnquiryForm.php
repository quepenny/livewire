<?php

namespace Quepenny\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Quepenny\Livewire\Models\Enquiry;

class EnquiryForm extends Form
{
    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $subject = '';

    #[Validate('required|string')]
    public string $message = '';

    #[Validate('accepted')]
    public bool $terms = false;

    public function store(): Enquiry
    {
        $this->validate();

        return Enquiry::query()->create($this->except('terms'));
    }

    public function notify(): void
    {
//        $this->validate();
//
//        Enquiry::query()->create($this->all());
    }
}
