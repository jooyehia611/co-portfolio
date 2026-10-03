<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'sort_order'];

    protected function casts(): array
    {
        return [
            'name' => TranslationCast::class,
            'description' => TranslationCast::class,
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }
}
