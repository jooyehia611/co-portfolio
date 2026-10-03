<?php

namespace App\Models;

use App\Enums\LeadStatus;
use App\Enums\ProjectType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactLead extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'company', 'service_id', 'budget_range_id',
        'project_type', 'message', 'status', 'ip_address', 'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
            'project_type' => ProjectType::class,
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function budgetRange(): BelongsTo
    {
        return $this->belongsTo(BudgetRange::class);
    }
}
