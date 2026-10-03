<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasTranslations;

    protected $fillable = ['label', 'value', 'suffix', 'icon', 'sort_order'];

    protected function casts(): array
    {
        return [
            'label' => TranslationCast::class,
        ];
    }
}
