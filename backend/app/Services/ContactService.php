<?php

namespace App\Services;

use App\Enums\LeadStatus;
use App\Mail\NewContactLeadMail;
use App\Models\ContactLead;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    public function storeLead(array $data, ?string $ip = null, ?string $userAgent = null): ContactLead
    {
        $lead = ContactLead::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'service_id' => $data['service_id'] ?? null,
            'message' => $data['message'],
            'status' => LeadStatus::New,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
        ]);

        $notifyEmail = env('LEAD_NOTIFICATION_EMAIL', config('mail.from.address'));
        Mail::to($notifyEmail)->send(new NewContactLeadMail($lead));

        return $lead;
    }
}
