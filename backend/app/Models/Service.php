<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Enums\ContentStatus;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'short_description', 'description', 'icon',
        'capabilities', 'business_problems',
        'featured_image_id', 'is_featured', 'status', 'sort_order',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'title' => TranslationCast::class,
            'short_description' => TranslationCast::class,
            'description' => TranslationCast::class,
            'meta_title' => TranslationCast::class,
            'meta_description' => TranslationCast::class,
            'capabilities' => 'array',
            'business_problems' => 'array',
            'is_featured' => 'boolean',
            'status' => ContentStatus::class,
        ];
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'featured_image_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_service');
    }

    public function contactLeads()
    {
        return $this->hasMany(ContactLead::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', ContentStatus::Published);
    }
}
