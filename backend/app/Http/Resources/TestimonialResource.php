<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client_name' => $this->client_name,
            'company' => $this->client_company,
            'position' => $this->client_title,
            'photo' => new MediaFileResource($this->whenLoaded('avatar')),
            'review' => $this->translate('content'),
            'rating' => (int) $this->rating,
            'audio_url' => $this->audio_path ? asset(\Illuminate\Support\Facades\Storage::disk('public')->url($this->audio_path)) : null,
            'audio_duration' => $this->audio_duration,
        ];
    }
}
