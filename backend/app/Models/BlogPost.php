<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Enums\ContentStatus;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'category_id', 'title', 'slug', 'excerpt', 'content', 'featured_image_id',
        'author_id', 'status', 'published_at', 'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'title' => TranslationCast::class,
            'excerpt' => TranslationCast::class,
            'content' => TranslationCast::class,
            'meta_title' => TranslationCast::class,
            'meta_description' => TranslationCast::class,
            'meta_keywords' => TranslationCast::class,
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'featured_image_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', ContentStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
