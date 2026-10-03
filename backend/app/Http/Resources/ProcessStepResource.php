<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessStepResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->translate('title'),
            'description' => $this->translate('description'),
            'step_number' => str_pad((string) $this->step_number, 2, '0', STR_PAD_LEFT),
            'icon' => $this->icon,
            'image' => new MediaFileResource($this->whenLoaded('image')),
            'sort_order' => $this->sort_order,
        ];
    }
}
