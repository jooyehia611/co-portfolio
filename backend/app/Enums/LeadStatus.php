<?php

namespace App\Enums;

enum LeadStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Qualified = 'qualified';
    case Converted = 'converted';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::New => __('admin.lead_status.new'),
            self::Contacted => __('admin.lead_status.contacted'),
            self::Qualified => __('admin.lead_status.qualified'),
            self::Converted => __('admin.lead_status.converted'),
            self::Closed => __('admin.lead_status.closed'),
        };
    }
}
