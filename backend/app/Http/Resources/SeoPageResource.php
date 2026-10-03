<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoPageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $ogImage = $this->relationLoaded('ogImage') && $this->ogImage
            ? $this->ogImage->url
            : null;

        return [
            'page_title' => $this->translate('page_title'),
            'page_description' => $this->translate('page_description'),
            'title' => $this->translate('meta_title'),
            'description' => $this->translate('meta_description'),
            'keywords' => $this->meta_keywords ?? null,
            'canonical_url' => $this->canonical_url,
            'og_image' => $ogImage,
            'og_title' => $this->translate('og_title') ?: $this->translate('meta_title'),
            'og_description' => $this->translate('og_description') ?: $this->translate('meta_description'),
            'robots' => $this->is_indexable ? 'index' : 'noindex',
            'page_key' => $this->page_key,
            'meta_title' => $this->translate('meta_title'),
            'meta_description' => $this->translate('meta_description'),
        ];
    }
}
