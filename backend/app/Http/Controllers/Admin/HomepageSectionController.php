<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use App\Models\MediaFile;
use App\Services\MediaService;
use App\Support\Translator;
use Illuminate\Http\Request;

class HomepageSectionController extends Controller
{
    public function __construct(private MediaService $mediaService) {}

    public function index()
    {
        return view('admin.homepage.index', [
            'sections' => HomepageSection::orderBy('sort_order')->get(),
        ]);
    }

    public function edit(HomepageSection $homepage)
    {
        return view('admin.homepage.edit', ['section' => $homepage]);
    }

    public function update(Request $request, HomepageSection $homepage)
    {
        $data = $request->validate([
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string|max:500',
            'subtitle_en' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($homepage->section_key !== 'hero') {
            $data = Translator::mergeFromRequest($data, ['title', 'subtitle']);
        }

        $existingContent = $homepage->content ?? [];

        $request->validate([
            'hero_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'about_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'about_image_two' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'wordmark_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'clients_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'video_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
        ]);

        match ($homepage->section_key) {
            'hero' => $this->applyHero($request, $data, $existingContent),
            'about' => $this->applyAbout($request, $data, $existingContent),
            'process' => $this->applyProcess($request, $data, $existingContent),
            'wordmark' => $this->applyWordmark($request, $data, $existingContent),
            'cta' => $this->applyCta($request, $data, $existingContent),
            'clients' => $this->applyClients($request, $data, $existingContent),
            'marquee' => $this->applyMarquee($request, $data, $existingContent),
            'video' => $this->applyVideo($request, $data, $existingContent),
            'services', 'projects', 'team', 'business_values' => $this->applyDescription($request, $data, $existingContent),
            default => $this->applyRawJson($data, $homepage),
        };

        $data['is_active'] = $request->boolean('is_active');

        $homepage->update($data);

        return redirect()->route('admin.homepage.index')->with('success', __('admin.messages.section_updated'));
    }

    private function applyHero(Request $request, array &$data, array $existing): void
    {
        $content = $this->buildHeroContent($request, $existing);
        $data['content'] = $content;
        $data['title'] = $content['headline_line1_prefix'] ?? null;
        $data['subtitle'] = $content['description'] ?? null;
    }

    private function applyAbout(Request $request, array &$data, array $existing): void
    {
        $imageMediaId = $this->resolveUploadedMediaId(
            $request,
            $existing,
            'image_media_id',
            'about_image',
            'remove_about_image',
            'about_image_alt',
            'about'
        );
        $imageTwoMediaId = $this->resolveUploadedMediaId(
            $request,
            $existing,
            'image_two_media_id',
            'about_image_two',
            'remove_about_image_two',
            'about_image_two_alt',
            'about'
        );

        $data['content'] = array_merge($existing, [
            'description' => $this->bilingualFromRequest($request, 'description', $existing['description'] ?? null),
            'years_count' => $request->filled('years_count')
                ? $request->input('years_count')
                : ($existing['years_count'] ?? null),
            'since_year' => $request->filled('since_year')
                ? $request->input('since_year')
                : ($existing['since_year'] ?? null),
            'progress_value' => $request->filled('progress_value')
                ? (int) $request->input('progress_value')
                : ($existing['progress_value'] ?? null),
            'progress_text' => $this->bilingualFromRequest($request, 'progress_text', $existing['progress_text'] ?? null),
            'solution_text' => $this->bilingualFromRequest($request, 'solution_text', $existing['solution_text'] ?? null),
            'cta_label' => $this->bilingualFromRequest($request, 'cta_label', $existing['cta_label'] ?? null),
            'cta_url' => $request->input('cta_url', $existing['cta_url'] ?? '/about'),
            'since_label' => $this->bilingualFromRequest($request, 'since_label', $existing['since_label'] ?? null),
            'award_winning' => $this->bilingualFromRequest($request, 'award_winning', $existing['award_winning'] ?? null),
            'experience_label' => $this->bilingualFromRequest($request, 'experience_label', $existing['experience_label'] ?? null),
            'challenge_label' => $this->bilingualFromRequest($request, 'challenge_label', $existing['challenge_label'] ?? null),
            'image_media_id' => $imageMediaId,
            'image_two_media_id' => $imageTwoMediaId,
        ]);
    }

    private function applyProcess(Request $request, array &$data, array $existing): void
    {
        $data['content'] = array_merge($existing, [
            'description' => $this->bilingualFromRequest($request, 'description', $existing['description'] ?? null),
            'cta_label' => $this->bilingualFromRequest($request, 'cta_label', $existing['cta_label'] ?? null),
            'cta_url' => $request->input('cta_url', $existing['cta_url'] ?? '/about'),
        ]);
    }

    private function applyWordmark(Request $request, array &$data, array $existing): void
    {
        $imageMediaId = $this->resolveUploadedMediaId(
            $request,
            $existing,
            'image_media_id',
            'wordmark_image',
            'remove_wordmark_image',
            'wordmark_image_alt',
            'wordmark'
        );

        $data['content'] = array_merge($existing, [
            'word' => $this->bilingualFromRequest($request, 'word', $existing['word'] ?? null),
            'image_media_id' => $imageMediaId,
        ]);
    }

    private function applyCta(Request $request, array &$data, array $existing): void
    {
        $data['content'] = array_merge($existing, [
            'eyebrow' => $this->bilingualFromRequest($request, 'eyebrow', $existing['eyebrow'] ?? null),
            'description' => $this->bilingualFromRequest($request, 'description', $existing['description'] ?? null),
            'cta_label' => $this->bilingualFromRequest($request, 'cta_label', $existing['cta_label'] ?? null),
            'cta_url' => $request->input('cta_url', $existing['cta_url'] ?? '/contact'),
        ]);
    }

    private function applyClients(Request $request, array &$data, array $existing): void
    {
        $imageMediaId = $this->resolveUploadedMediaId(
            $request,
            $existing,
            'image_media_id',
            'clients_image',
            'remove_clients_image',
            'clients_image_alt',
            'clients'
        );

        $existingItems = $existing['items'] ?? [];
        $itemCount = max((int) $request->input('items_count', count($existingItems)), count($existingItems));
        $items = [];

        for ($i = 0; $i < $itemCount; $i++) {
            $title = $this->bilingualFromRequest(
                $request,
                "item_{$i}_title",
                $existingItems[$i]['title'] ?? null
            );
            $description = $this->bilingualFromRequest(
                $request,
                "item_{$i}_description",
                $existingItems[$i]['description'] ?? null
            );

            if ($this->isEmptyBilingual($title) && $this->isEmptyBilingual($description)) {
                continue;
            }

            $items[] = [
                'title' => $title,
                'description' => $description,
            ];
        }

        $data['content'] = array_merge($existing, [
            'badge_text' => $this->bilingualFromRequest($request, 'badge_text', $existing['badge_text'] ?? null),
            'description' => $this->bilingualFromRequest($request, 'description', $existing['description'] ?? null),
            'items' => $items !== [] ? $items : $existingItems,
            'image_media_id' => $imageMediaId,
        ]);
    }

    private function applyMarquee(Request $request, array &$data, array $existing): void
    {
        $existingItems = $existing['items'] ?? [];
        $itemCount = max((int) $request->input('items_count', count($existingItems)), count($existingItems));
        $items = [];

        for ($i = 0; $i < $itemCount; $i++) {
            $item = $this->bilingualFromRequest($request, "marquee_item_{$i}", $existingItems[$i] ?? null);
            if ($this->isEmptyBilingual($item)) {
                continue;
            }
            $items[] = $item;
        }

        $data['content'] = array_merge($existing, [
            'items' => $items !== [] ? $items : $existingItems,
        ]);
    }

    private function applyVideo(Request $request, array &$data, array $existing): void
    {
        $imageMediaId = $this->resolveUploadedMediaId(
            $request,
            $existing,
            'image_media_id',
            'video_image',
            'remove_video_image',
            'video_image_alt',
            'video'
        );

        $data['content'] = array_merge($existing, [
            'video_url' => $request->input('video_url', $existing['video_url'] ?? null),
            'image_media_id' => $imageMediaId,
        ]);
    }

    private function applyDescription(Request $request, array &$data, array $existing): void
    {
        $data['content'] = array_merge($existing, [
            'description' => $this->bilingualFromRequest($request, 'description', $existing['description'] ?? null),
        ]);
    }

    private function applyRawJson(array &$data, HomepageSection $homepage): void
    {
        if (isset($data['content'])) {
            $data['content'] = json_decode($data['content'], true) ?? $homepage->content;
        }
    }

    private function buildHeroContent(Request $request, array $existing): array
    {
        $ctaPrimaryLabel = $this->bilingualFromRequest(
            $request,
            'cta_primary_label',
            $existing['cta_primary']['label'] ?? null
        );

        $ctaSecondaryLabel = $this->bilingualFromRequest(
            $request,
            'cta_secondary_label',
            $existing['cta_secondary']['label'] ?? null
        );

        $content = array_merge($existing, [
            'kicker' => $this->bilingualFromRequest($request, 'kicker', $existing['kicker'] ?? null),
            'headline_line1_prefix' => $this->bilingualFromRequest($request, 'headline_line1_prefix', $existing['headline_line1_prefix'] ?? null),
            'headline_line1_accent' => $this->bilingualFromRequest($request, 'headline_line1_accent', $existing['headline_line1_accent'] ?? null),
            'headline_line2' => $this->bilingualFromRequest($request, 'headline_line2', $existing['headline_line2'] ?? null),
            'description' => $this->bilingualFromRequest($request, 'description', $existing['description'] ?? null),
            'float_grow_title' => $this->bilingualFromRequest($request, 'float_grow_title', $existing['float_grow_title'] ?? null),
            'float_grow_sub' => $this->bilingualFromRequest($request, 'float_grow_sub', $existing['float_grow_sub'] ?? null),
            'float_idea_title' => $this->bilingualFromRequest($request, 'float_idea_title', $existing['float_idea_title'] ?? null),
            'float_idea_sub' => $this->bilingualFromRequest($request, 'float_idea_sub', $existing['float_idea_sub'] ?? null),
            'script_line1' => $this->bilingualFromRequest($request, 'script_line1', $existing['script_line1'] ?? null),
            'script_line2' => $this->bilingualFromRequest($request, 'script_line2', $existing['script_line2'] ?? null),
            'cta_primary' => [
                'label' => $ctaPrimaryLabel,
                'url' => $request->input('cta_primary_url', $existing['cta_primary']['url'] ?? '/contact'),
            ],
            'cta_secondary' => [
                'label' => $ctaSecondaryLabel,
                'url' => $request->input('cta_secondary_url', $existing['cta_secondary']['url'] ?? '/work'),
            ],
        ]);

        unset(
            $content['capabilities'],
            $content['eyebrow_brand'],
            $content['eyebrow_tagline'],
            $content['panel_eyebrow'],
            $content['panel_title'],
            $content['float_top_label'],
        );

        return $content;
    }

    private function resolveUploadedMediaId(
        Request $request,
        array $existing,
        string $contentKey,
        string $fileField,
        string $removeField,
        string $altField,
        string $folder
    ): mixed {
        $imageMediaId = $existing[$contentKey] ?? null;

        if ($request->boolean($removeField)) {
            return null;
        }

        if ($request->hasFile($fileField)) {
            $media = $this->mediaService->upload(
                $request->file($fileField),
                $request->input($altField),
                $folder
            );

            return $media->id;
        }

        if ($imageMediaId && $request->filled($altField)) {
            MediaFile::whereKey($imageMediaId)->update([
                'alt_text' => $request->input($altField),
            ]);
        }

        return $imageMediaId;
    }

    private function bilingualFromRequest(Request $request, string $name, mixed $existing = null): mixed
    {
        $ar = $request->input("{$name}_ar");
        $en = $request->input("{$name}_en");

        if ($ar === null && $en === null) {
            return $existing;
        }

        $ar = trim((string) ($ar ?? ''));
        $en = trim((string) ($en ?? ''));

        if ($ar === '' && $en === '') {
            return $existing;
        }

        return [
            'ar' => $ar !== '' ? $ar : $en,
            'en' => $en !== '' ? $en : $ar,
        ];
    }

    private function isEmptyBilingual(mixed $value): bool
    {
        if (! is_array($value)) {
            return trim((string) $value) === '';
        }

        return trim((string) ($value['ar'] ?? '')) === '' && trim((string) ($value['en'] ?? '')) === '';
    }
}
