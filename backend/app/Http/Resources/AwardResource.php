<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AwardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'year' => (string) $this->year,
            'title' => $this->translate('title') ?? '',
            'platform' => $this->translate('platform'),
            'result' => $this->translate('result'),
            'link_url' => $this->link_url,
            'logo' => new MediaFileResource($this->whenLoaded('logo')),
            'sort_order' => (int) $this->sort_order,
        ];
    }
}
