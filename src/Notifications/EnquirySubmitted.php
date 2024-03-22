<?php

namespace Quepenny\Livewire\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Quepenny\Livewire\Mail;
use Quepenny\Livewire\Models\Enquiry;

class EnquirySubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function via(Enquiry $enquiry): array
    {
        return ['mail'];
    }

    public function toMail(Enquiry $enquiry): Mail\EnquirySubmitted
    {
        return new Mail\EnquirySubmitted($enquiry);
    }
}
