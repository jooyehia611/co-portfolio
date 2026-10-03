<?php

namespace App\Http\Resources;

use App\Support\Translator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'key' => $this->key,
            'value' => Translator::get($this->value),
            'group' => $this->group,
            'type' => $this->type,
        ];
    }
}
