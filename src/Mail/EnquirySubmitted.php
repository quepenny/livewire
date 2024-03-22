<?php

namespace Quepenny\Livewire\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Quepenny\Livewire\Models\Enquiry;

class EnquirySubmitted extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly Enquiry $enquiry)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: config('mail.to.address'),
            subject: 'Enquiry Submitted: ' . $this->enquiry->subject,
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.enquiry.submitted');
    }
}
