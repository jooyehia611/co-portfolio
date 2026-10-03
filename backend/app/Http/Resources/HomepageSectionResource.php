<?php

namespace App\Http\Resources;

use App\Support\Translator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomepageSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'section_key' => $this->section_key,
            'title' => $this->translate('title'),
            'subtitle' => $this->translate('subtitle'),
            'content' => Translator::translateContent($this->content),
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];
    }
}
