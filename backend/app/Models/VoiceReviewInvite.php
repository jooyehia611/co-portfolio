<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoiceReviewInvite extends Model
{
    protected $fillable = ['token_hash', 'client_name', 'expires_at', 'used_at'];

    protected function casts(): array
    {
        return ['expires_at' => 'datetime', 'used_at' => 'datetime'];
    }
}
