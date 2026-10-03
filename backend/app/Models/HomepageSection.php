<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    use HasTranslations;

    protected $fillable = [
        'section_key', 'title', 'subtitle', 'content', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'title' => TranslationCast::class,
            'subtitle' => TranslationCast::class,
            'content' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
