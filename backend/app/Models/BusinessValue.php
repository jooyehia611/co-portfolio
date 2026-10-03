<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class BusinessValue extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'icon', 'sort_order'];

    protected function casts(): array
    {
        return [
            'title' => TranslationCast::class,
            'description' => TranslationCast::class,
        ];
    }
}
