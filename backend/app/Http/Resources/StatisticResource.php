<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->translate('label'),
            'value' => $this->value,
            'suffix' => $this->suffix,
            'icon' => $this->icon,
            'sort_order' => $this->sort_order,
        ];
    }
}
