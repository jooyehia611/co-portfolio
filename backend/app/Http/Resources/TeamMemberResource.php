<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamMemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->translate('role'),
            'bio' => $this->translate('bio') ?? '',
            'photo' => new MediaFileResource($this->whenLoaded('photo')),
            'linkedin_url' => $this->linkedin_url,
            'github_url' => $this->github_url,
        ];
    }
}
