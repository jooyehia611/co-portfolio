<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_name' => $this->name,
            'name' => $this->name,
            'logo' => new MediaFileResource($this->whenLoaded('logo')),
            'website_url' => $this->website_url,
        ];
    }
}
