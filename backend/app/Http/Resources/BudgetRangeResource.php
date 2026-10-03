<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetRangeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->translate('label'),
            'min_amount' => $this->min_amount,
            'max_amount' => $this->max_amount,
            'sort_order' => $this->sort_order,
        ];
    }
}
