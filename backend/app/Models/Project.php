<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Enums\ContentStatus;
use App\Enums\ProjectType;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'client_name', 'industry', 'year', 'project_type',
        'short_description', 'description', 'challenge', 'solution', 'approach',
        'design_notes', 'development_notes', 'key_features', 'results', 'timeline',
        'featured_image_id', 'cover_image_id', 'live_url', 'video_url', 'github_url',
        'completion_date', 'is_featured', 'status', 'sort_order', 'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'title' => TranslationCast::class,
            'short_description' => TranslationCast::class,
            'description' => TranslationCast::class,
            'challenge' => TranslationCast::class,
            'solution' => TranslationCast::class,
            'approach' => TranslationCast::class,
            'design_notes' => TranslationCast::class,
            'development_notes' => TranslationCast::class,
            'timeline' => TranslationCast::class,
            'meta_title' => TranslationCast::class,
            'meta_description' => TranslationCast::class,
            'project_type' => ProjectType::class,
            'status' => ContentStatus::class,
            'is_featured' => 'boolean',
            'completion_date' => 'date',
            'key_features' => 'array',
            'results' => 'array',
            'year' => 'integer',
        ];
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'featured_image_id');
    }

    public function coverImage(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'cover_image_id');
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(ProjectGallery::class)->orderBy('sort_order');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'project_service');
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class, 'project_technology');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', ContentStatus::Published);
    }
}
