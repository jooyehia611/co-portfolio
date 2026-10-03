<x-mail::message>
# New Contact Lead

You have received a new contact form submission from the Ytech portfolio website.

**Name:** {{ $lead->name }}  
**Email:** {{ $lead->email }}  
@if($lead->phone)
**Phone:** {{ $lead->phone }}  
@endif
@if($lead->company)
**Company:** {{ $lead->company }}  
@endif

**Message:**

{{ $lead->message }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
