<?php

namespace App\Http\Resources;

use App\Support\FeatureGroups;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isDetail = $request->route()?->parameter('slug') !== null
            && str_contains($request->path(), 'projects/');

        return [
            'id' => $this->id,
            'title' => $this->translate('title'),
            'slug' => $this->slug,
            'client_name' => $this->client_name,
            'year' => $this->year ?? $this->completion_date?->format('Y'),
            'short_description' => $this->translate('short_description'),
            'description' => $this->when($isDetail, $this->translate('description')),
            'cover' => $this->whenLoaded('coverImage', fn () => $this->coverImage
                ? new MediaFileResource($this->coverImage)
                : null),
            'thumbnail' => $this->whenLoaded('featuredImage', fn () => $this->featuredImage
                ? new MediaFileResource($this->featuredImage)
                : null),
            'website_url' => $this->live_url,
            'is_featured' => $this->is_featured,
            'services' => ServiceResource::collection($this->whenLoaded('services')),
            'technologies' => TechnologyResource::collection($this->whenLoaded('technologies')),
            'challenge' => $this->when($isDetail, $this->translate('challenge')),
            'solution' => $this->when($isDetail, $this->translate('solution')),
            'approach' => $this->when($isDetail, $this->translate('approach')),
            'design_notes' => $this->when($isDetail, $this->translate('design_notes')),
            'development_notes' => $this->when($isDetail, $this->translate('development_notes')),
            'key_features' => $this->when($isDetail, FeatureGroups::forApi($this->key_features)),
            'results' => $this->when($isDetail, $this->results ?? []),
            'timeline' => $this->when($isDetail, $this->translate('timeline')),
            'video_url' => $this->when($isDetail, $this->video_url),
            'gallery' => $this->when($isDetail && $this->relationLoaded('gallery'), function () {
                return $this->gallery->map(fn ($item) => [
                    'id' => $item->id,
                    'url' => $item->mediaFile?->url,
                    'caption' => $item->caption,
                ])->filter(fn ($g) => $g['url'])->values();
            }),
            'related_projects' => $this->when($isDetail, []),
            'seo' => [
                'title' => $this->translate('meta_title') ?: $this->translate('title'),
                'description' => $this->translate('meta_description') ?: $this->translate('short_description'),
            ],
        ];
    }
}
