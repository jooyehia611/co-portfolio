<?php

namespace App\Services;

use App\Http\Resources\MediaFileResource;
use App\Models\MediaFile;
use App\Models\Setting;
use App\Support\Translator;
use Illuminate\Support\Collection;

class SettingsService
{
    public function all(): array
    {
        $settings = Setting::all()->keyBy('key');

        return $this->transform($settings);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $value = Setting::where('key', $key)->value('value') ?? $default;

        return Translator::get($value);
    }

    public function getRaw(string $key, mixed $default = null): mixed
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }

    private function transform(Collection $settings): array
    {
        $resolveMedia = function (?int $id): ?array {
            if (! $id) {
                return null;
            }

            $file = MediaFile::find($id);

            return $file
                ? (new MediaFileResource($file))->resolve(request())
                : null;
        };

        $companyName = Translator::get($settings->get('company_name')?->value ?? 'Ytech');
        $logoId = $settings->get('logo_id')?->value;
        $faviconId = $settings->get('favicon_id')?->value;
        $ogId = $settings->get('default_og_image_id')?->value;

        return [
            'company_name' => $companyName,
            'site_title' => Translator::get($settings->get('site_title')?->value) ?: $companyName,
            'tagline' => Translator::get($settings->get('tagline')?->value),
            'logo' => $resolveMedia($logoId ? (int) $logoId : null)
                ?? $this->defaultBrandAsset('logo-stacked.png', $companyName),
            'favicon' => $resolveMedia($faviconId ? (int) $faviconId : null)
                ?? $this->defaultBrandAsset('logo-icon.png', $companyName),
            'email' => $settings->get('email')?->value ?? 'hello@ytech.com',
            'phone' => $settings->get('phone')?->value,
            'whatsapp' => $settings->get('whatsapp')?->value,
            'address' => Translator::get($settings->get('address')?->value),
            'social' => [
                'linkedin' => $settings->get('linkedin_url')?->value,
                'twitter' => $settings->get('twitter_url')?->value,
                'instagram' => $settings->get('instagram_url')?->value,
                'facebook' => $settings->get('facebook_url')?->value,
                'behance' => $settings->get('behance_url')?->value,
                'dribbble' => $settings->get('dribbble_url')?->value,
                'github' => $settings->get('github_url')?->value,
            ],
            'footer_text' => Translator::get($settings->get('footer_text')?->value),
            'default_og_image' => $resolveMedia($ogId ? (int) $ogId : null),
            'ui' => [
                'view_all' => Translator::get($settings->get('view_all_label')?->value) ?: 'View all',
                'explore' => Translator::get($settings->get('explore_label')?->value) ?: 'Explore',
                'projects_count' => Translator::get($settings->get('projects_count_label')?->value) ?: 'Projects',
                'services' => Translator::get($settings->get('services_label')?->value) ?: 'Services',
            ],
        ];
    }

    private function defaultBrandAsset(string $filename, string $alt): array
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $mime = match ($extension) {
            'png' => 'image/png',
            'ico' => 'image/x-icon',
            'jpg', 'jpeg' => 'image/jpeg',
            default => 'image/svg+xml',
        };

        return [
            'id' => 0,
            'filename' => $filename,
            'original_name' => $filename,
            'url' => asset('brand/'.$filename),
            'mime_type' => $mime,
            'size' => 0,
            'alt_text' => $alt,
        ];
    }
}
