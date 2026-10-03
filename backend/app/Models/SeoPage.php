<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoPage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'page_key', 'slug', 'page_title', 'page_description',
        'meta_title', 'meta_description',
        'og_title', 'og_description', 'og_image_id', 'canonical_url', 'is_indexable',
    ];

    protected function casts(): array
    {
        return [
            'page_title' => TranslationCast::class,
            'page_description' => TranslationCast::class,
            'meta_title' => TranslationCast::class,
            'meta_description' => TranslationCast::class,
            'og_title' => TranslationCast::class,
            'og_description' => TranslationCast::class,
            'is_indexable' => 'boolean',
        ];
    }

    public function ogImage(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'og_image_id');
    }
}
