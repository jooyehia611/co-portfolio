<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Enums\ContentStatus;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'client_name', 'client_title', 'client_company', 'content', 'rating',
        'avatar_id', 'project_id', 'is_featured', 'status', 'sort_order',
        'audio_path', 'audio_duration',
    ];

    protected function casts(): array
    {
        return [
            'content' => TranslationCast::class,
            'is_featured' => 'boolean',
            'status' => ContentStatus::class,
        ];
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'avatar_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', ContentStatus::Published);
    }
}
