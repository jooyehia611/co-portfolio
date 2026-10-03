<?php

namespace App\Models;

use App\Casts\TranslationCast;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessStep extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'step_number', 'icon', 'image_id', 'sort_order'];

    protected function casts(): array
    {
        return [
            'title' => TranslationCast::class,
            'description' => TranslationCast::class,
        ];
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class, 'image_id');
    }
}
