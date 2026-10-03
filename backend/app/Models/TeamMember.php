<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'role', 'bio', 'email', 'photo_id',
        'linkedin_url', 'twitter_url', 'github_url', 'is_featured', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'role' => TranslationCast::class,
            'bio' => TranslationCast::class,
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'photo_id');
    }
}
