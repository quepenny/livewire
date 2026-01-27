<?php

use Livewire\Component;
use Quepenny\Livewire\Forms\EnquiryForm;
use Quepenny\Livewire\Notifications\EnquirySubmitted;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.form-page')] class extends Component
{
    public EnquiryForm $form;

    public bool $submitted = false;

    public function submit(): void
    {
        $enquiry = $this->form->store();
        $enquiry->notify(new EnquirySubmitted);
        $this->submitted = true;
    }

    public function with(): array
    {
        return [
            'title' => __('quepenny::enquiry.title'),
            'nav' => ['active' => 'contact'],
            'mainTitle' => __('quepenny::enquiry.title'),
            'subTitle' => __('quepenny::enquiry.subtitle'),
            'buttonText' => __('quepenny::enquiry.button_text'),
        ];
    }
};
?>

<main>
    @if($submitted)
        <div class="p-4 bg-green-100 border-l-4 border-green-500">
            <p class="text-green-700">
                {{ __('quepenny::enquiry.success_message') }}
            </p>
        </div>
    @else
        <x-input.text
            field="form.subject"
            label="{{ __('quepenny::enquiry.labels.subject') }}"
        />

        <x-input.text
            field="form.name"
            label="{{ __('quepenny::enquiry.labels.name') }}"
        />

        <x-input.text
            field="form.email"
            type="email"
            label="{{ __('quepenny::enquiry.labels.email') }}"
        />

        <x-input.textarea
            field="form.message"
            label="{{ __('quepenny::enquiry.labels.message') }}"
        />

        <p class="mb-2 text-xs">
            {{ __('I agree to') }}

            <a
                    target="_blank"
                    href="{{ route('terms') }}"
                    class="underline text-gray-600 hover:text-gray-900"
            >
                {{ __('Terms of Use') }}
            </a>

            and

            <a
                    target="_blank"
                    href="{{ route('privacy') }}"
                    class="underline text-gray-600 hover:text-gray-900"
            >
                {{ __('Privacy Policy') }}
            </a>
        </p>

        <x-input.checkbox
            field="form.terms"
            label="{{ __('quepenny::enquiry.labels.terms') }}"
        />

        <x-button
                class="w-full justify-center font-bold text-white"
                action="submit"
        >
            {{ __('quepenny::enquiry.button_text') }}
        </x-button>
    @endif
</main>
