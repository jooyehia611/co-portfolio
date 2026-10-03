<?php

namespace App\Http\Resources;

use App\Support\Translator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $cover = new MediaFileResource($this->whenLoaded('featuredImage'));
        $isDetail = $request->route()?->parameter('slug') !== null
            && str_contains($request->path(), 'services/');

        return [
            'id' => $this->id,
            'title' => $this->translate('title'),
            'slug' => $this->slug,
            'icon' => $this->icon,
            'short_description' => $this->translate('short_description'),
            'full_description' => $this->when($isDetail, $this->translate('description')),
            'cover' => $cover,
            'capabilities' => $this->when($isDetail, Translator::get($this->capabilities ?? [])),
            'business_problems' => $this->when($isDetail, Translator::get($this->business_problems ?? [])),
            'is_featured' => $this->is_featured,
            'order' => $this->sort_order,
            'related_projects' => $this->when($isDetail && $this->relationLoaded('projects'), function () {
                return ProjectResource::collection($this->projects->take(3));
            }),
            'seo' => [
                'title' => $this->translate('meta_title') ?: $this->translate('title'),
                'description' => $this->translate('meta_description') ?: $this->translate('short_description'),
            ],
        ];
    }
}
