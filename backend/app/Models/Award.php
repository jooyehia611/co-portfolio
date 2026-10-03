<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Award extends Model
{
    use HasTranslations;

    protected $fillable = [
        'year', 'title', 'platform', 'result', 'link_url',
        'logo_id', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'title' => TranslationCast::class,
            'platform' => TranslationCast::class,
            'result' => TranslationCast::class,
            'is_active' => 'boolean',
        ];
    }

    public function logo(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'logo_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
