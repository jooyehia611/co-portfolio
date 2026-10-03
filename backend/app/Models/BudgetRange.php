<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetRange extends Model
{
    use HasTranslations;

    protected $fillable = ['label', 'min_amount', 'max_amount', 'sort_order'];

    protected function casts(): array
    {
        return [
            'label' => TranslationCast::class,
            'min_amount' => 'decimal:2',
            'max_amount' => 'decimal:2',
        ];
    }

    public function contactLeads(): HasMany
    {
        return $this->hasMany(ContactLead::class);
    }
}
