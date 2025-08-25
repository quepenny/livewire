<x-mail::message>
# Hello {{ config('app.name') }}

An enquiry has been submitted on {{ config('app.url') }}.

<x-mail::panel>
Name: {{ $enquiry->name }}

Email: {{ $enquiry->email }}

Subject: {{ $enquiry->subject }}

Message: {{ $enquiry->message }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
