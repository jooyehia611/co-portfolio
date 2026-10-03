<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'filename', 'original_name', 'path', 'mime_type', 'size', 'alt_text', 'disk',
    ];

    public function getUrlAttribute(): string
    {
        return asset('storage/'.$this->path);
    }
}
