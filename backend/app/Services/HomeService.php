<?php

namespace App\Services;

use App\Http\Resources\AwardResource;
use App\Http\Resources\BusinessValueResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ProcessStepResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SeoPageResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\StatisticResource;
use App\Http\Resources\TeamMemberResource;
use App\Http\Resources\TechnologyResource;
use App\Http\Resources\TestimonialResource;
use App\Models\Award;
use App\Models\BusinessValue;
use App\Models\Client;
use App\Models\HomepageSection;
use App\Models\MediaFile;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\SeoPage;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\TeamMember;
use App\Models\Technology;
use App\Models\Testimonial;
use App\Support\Translator;

class HomeService
{
    public function __construct(private SettingsService $settingsService) {}

    public function getHomeData(): array
    {
        $sections = HomepageSection::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');

        $heroSection = $sections->get('hero');
        $heroContent = $heroSection?->content ?? [];

        $statistics = Statistic::where('is_active', true)->orderBy('sort_order')->get();

        $hero = [
            'kicker' => Translator::get($heroContent['kicker'] ?? null) ?: __('home.sections.hero.kicker'),
            'headline' => [
                'line1_prefix' => Translator::get($heroContent['headline_line1_prefix'] ?? null) ?: __('home.sections.hero.headline_line1_prefix'),
                'line1_accent' => Translator::get($heroContent['headline_line1_accent'] ?? null) ?: __('home.sections.hero.headline_line1_accent'),
                'line2' => Translator::get($heroContent['headline_line2'] ?? null) ?: __('home.sections.hero.headline_line2'),
            ],
            'description' => Translator::get($heroContent['description'] ?? null)
                ?: $heroSection?->translate('subtitle')
                ?: Translator::get($this->settingsService->getRaw('tagline', '')),
            'primary_cta' => [
                'label' => Translator::get($heroContent['cta_primary']['label'] ?? null) ?: __('home.cta.start_project'),
                'href' => $heroContent['cta_primary']['url'] ?? '/contact',
            ],
            'secondary_cta' => [
                'label' => Translator::get($heroContent['cta_secondary']['label'] ?? null) ?: __('home.cta.view_work'),
                'href' => $heroContent['cta_secondary']['url'] ?? '/work',
            ],
            'float_grow' => [
                'title' => Translator::get($heroContent['float_grow_title'] ?? null) ?: __('home.sections.hero.float_grow_title'),
                'subtitle' => Translator::get($heroContent['float_grow_sub'] ?? null) ?: __('home.sections.hero.float_grow_sub'),
            ],
            'float_idea' => [
                'title' => Translator::get($heroContent['float_idea_title'] ?? null) ?: __('home.sections.hero.float_idea_title'),
                'subtitle' => Translator::get($heroContent['float_idea_sub'] ?? null) ?: __('home.sections.hero.float_idea_sub'),
            ],
            'script' => [
                'line1' => Translator::get($heroContent['script_line1'] ?? null) ?: __('home.sections.hero.script_line1'),
                'line2' => Translator::get($heroContent['script_line2'] ?? null) ?: __('home.sections.hero.script_line2'),
            ],
        ];

        $clientsSection = $sections->get('clients');
        $clientsContent = $clientsSection?->content ?? [];

        $section = fn (string $key, string $titleKey, ?string $descKey = null, ?string $subtitleKey = null) => [
            'title' => $sections->get($key)?->translate('title') ?? __($titleKey),
            'subtitle' => $sections->get($key)?->translate('subtitle')
                ?: ($subtitleKey ? __($subtitleKey) : null),
            'description' => Translator::get($sections->get($key)?->content['description'] ?? null)
                ?? ($descKey ? __($descKey) : null),
        ];

        $ctaSection = $sections->get('cta');
        $ctaContent = $ctaSection?->content ?? [];
        $processSection = $sections->get('process');
        $processContent = $processSection?->content ?? [];

        $aboutSection = $sections->get('about');
        $aboutContent = $aboutSection?->content ?? [];
        $videoSection = $sections->get('video');
        $videoContent = $videoSection?->content ?? [];
        $wordmarkSection = $sections->get('wordmark');
        $wordmarkContent = $wordmarkSection?->content ?? [];
        $marqueeSection = $sections->get('marquee');
        $marqueeContent = $marqueeSection?->content ?? [];

        $seoPage = SeoPage::where('page_key', 'home')->first();

        return [
            'hero' => $hero,
            'ui' => [
                'view_all' => $this->settingsService->get('view_all_label', __('home.ui.view_all')),
                'explore' => $this->settingsService->get('explore_label', __('home.ui.explore')),
                'projects_count' => $this->settingsService->get('projects_count_label', __('home.ui.projects_count')),
                'services' => $this->settingsService->get('services_label', __('home.ui.services')),
            ],
            'sections' => [
                'clients' => [
                    'title' => $clientsSection?->translate('title') ?? __('home.sections.clients.title'),
                    'subtitle' => $clientsSection?->translate('subtitle') ?? __('home.sections.clients.subtitle'),
                    'description' => Translator::get($clientsContent['description'] ?? null)
                        ?: __('home.sections.clients.description'),
                    'badge_text' => Translator::get($clientsContent['badge_text'] ?? null)
                        ?: __('home.sections.clients.badge_text'),
                    'image' => $this->resolveSectionImage($clientsContent),
                    'items' => $this->resolveFocusAreas($clientsContent),
                    'logos' => ClientResource::collection(
                        Client::with('logo')->where('is_featured', true)->orderBy('sort_order')->limit(8)->get()
                    ),
                ],
                'services' => $section(
                    'services',
                    'home.sections.services.title',
                    'home.sections.services.description',
                    'home.sections.services.subtitle'
                ),
                'projects' => $section('projects', 'home.sections.projects.title', 'home.sections.projects.description'),
                'business_values' => $section('business_values', 'home.sections.business_values.title', 'home.sections.business_values.description'),
                'process' => [
                    'title' => $processSection?->translate('title') ?? __('home.sections.process.title'),
                    'subtitle' => $processSection?->translate('subtitle'),
                    'description' => Translator::get($processContent['description'] ?? null),
                    'button_label' => Translator::get($processContent['cta_label'] ?? null),
                    'button_href' => $processContent['cta_url'] ?? '/about',
                ],
                'technology' => $section('technology', 'home.sections.technology.title'),
                'statistics' => $section('statistics', 'home.sections.statistics.title'),
                'testimonials' => $section('testimonials', 'home.sections.testimonials.title'),
                'cta' => [
                    'title' => $ctaSection?->translate('title') ?? __('home.sections.cta.title'),
                    'subtitle' => $ctaSection?->translate('subtitle'),
                    'description' => Translator::get($ctaContent['description'] ?? null)
                        ?: $ctaSection?->translate('subtitle')
                        ?: __('home.sections.cta.description'),
                    'eyebrow' => Translator::get($ctaContent['eyebrow'] ?? null),
                    'button_label' => Translator::get($ctaContent['cta_label'] ?? null) ?: __('home.cta.start_conversation'),
                    'button_href' => $ctaContent['cta_url'] ?? '/contact',
                ],
                'about' => [
                    'title' => $aboutSection?->translate('title') ?? '',
                    'subtitle' => $aboutSection?->translate('subtitle'),
                    'description' => Translator::get($aboutContent['description'] ?? null),
                    'years_count' => $aboutContent['years_count'] ?? null,
                    'progress_value' => isset($aboutContent['progress_value'])
                        ? (int) $aboutContent['progress_value']
                        : null,
                    'progress_text' => Translator::get($aboutContent['progress_text'] ?? null),
                    'solution_text' => Translator::get($aboutContent['solution_text'] ?? null),
                    'button_label' => Translator::get($aboutContent['cta_label'] ?? null),
                    'button_href' => $aboutContent['cta_url'] ?? '/about',
                    'image' => $this->resolveMediaById($aboutContent['image_media_id'] ?? null),
                    'image_two' => $this->resolveMediaById($aboutContent['image_two_media_id'] ?? null),
                    'since_year' => $aboutContent['since_year'] ?? null,
                    'since_label' => Translator::get($aboutContent['since_label'] ?? null),
                    'award_winning' => Translator::get($aboutContent['award_winning'] ?? null),
                    'experience_label' => Translator::get($aboutContent['experience_label'] ?? null),
                    'challenge_label' => Translator::get($aboutContent['challenge_label'] ?? null),
                ],
                'team' => $section('team', 'home.sections.team.title'),
                'awards' => $section('awards', 'home.sections.awards.title'),
                'video' => [
                    'title' => $videoSection?->translate('title') ?? '',
                    'subtitle' => $videoSection?->translate('subtitle'),
                    'video_url' => $videoContent['video_url'] ?? null,
                    'image' => $this->resolveMediaById($videoContent['image_media_id'] ?? null),
                ],
                'wordmark' => [
                    'word' => Translator::get($wordmarkContent['word'] ?? null)
                        ?: ($wordmarkSection?->translate('title') ?? ''),
                    'image' => $this->resolveMediaById($wordmarkContent['image_media_id'] ?? null),
                ],
                'marquee' => [
                    'items' => collect($marqueeContent['items'] ?? [])
                        ->map(fn ($item) => trim((string) Translator::get($item)))
                        ->filter()
                        ->values()
                        ->all(),
                ],
            ],
            'awards' => AwardResource::collection(
                Award::active()->with('logo')->orderBy('sort_order')->get()
            ),
            'team_members' => TeamMemberResource::collection($this->homeTeamMembers()),
            'services' => ServiceResource::collection(
                Service::published()
                    ->with('featuredImage')
                    ->orderByDesc('is_featured')
                    ->orderBy('sort_order')
                    ->limit(8)
                    ->get()
            ),
            'projects' => ProjectResource::collection(
                Project::published()->with(['coverImage', 'featuredImage', 'technologies', 'services'])
                    ->orderBy('sort_order')->get()
            ),
            'business_values' => BusinessValueResource::collection(
                BusinessValue::orderBy('sort_order')->get()
            ),
            'process_steps' => ProcessStepResource::collection(
                ProcessStep::with('image')->orderBy('sort_order')->get()
            ),
            'technologies' => TechnologyResource::collection(
                Technology::with('logo')->where('is_active', true)->orderBy('sort_order')->limit(16)->get()
            ),
            'statistics' => StatisticResource::collection($statistics),
            'testimonials' => TestimonialResource::collection(
                Testimonial::published()->with('avatar')->whereNotNull('audio_path')->orderBy('sort_order')->latest()->limit(6)->get()
            ),
            'seo' => $seoPage ? (new SeoPageResource($seoPage))->toArray(request()) : null,
        ];
    }

    private function homeTeamMembers()
    {
        $featured = TeamMember::with('photo')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        if ($featured->isNotEmpty()) {
            return $featured;
        }

        return TeamMember::with('photo')->orderBy('sort_order')->limit(8)->get();
    }

    private function resolveLocalizedText(mixed $value, string $fallbackKey): string
    {
        $translated = trim((string) Translator::get($value));

        if ($translated === '') {
            return (string) __($fallbackKey);
        }

        // English-only values stored under AR (plain string or translation map) → use lang fallback.
        if (app()->getLocale() === 'ar' && ! preg_match('/\p{Arabic}/u', $translated)) {
            return (string) __($fallbackKey);
        }

        return $translated;
    }

    private function resolveFocusAreas(array $content): array
    {
        $items = collect($content['items'] ?? [])
            ->map(fn (array $item) => [
                'title' => Translator::get($item['title'] ?? null),
                'description' => Translator::get($item['description'] ?? null),
            ])
            ->filter(fn (array $item) => $item['title'] !== '' && $item['description'] !== '')
            ->values()
            ->all();

        if ($items !== []) {
            return $items;
        }

        return collect(__('home.sections.clients.items'))
            ->map(fn (array $item) => [
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
            ])
            ->all();
    }

    private function resolveSectionImage(array $content): ?array
    {
        return $this->resolveMediaById($content['image_media_id'] ?? null);
    }

    private function resolveHeroImage(array $heroContent): ?array
    {
        return $this->resolveMediaById($heroContent['image_media_id'] ?? null);
    }

    private function resolveMediaById(mixed $mediaId): ?array
    {
        if (! $mediaId) {
            return null;
        }

        $media = MediaFile::find($mediaId);
        if (! $media) {
            return null;
        }

        return [
            'url' => $media->url,
            'alt' => $media->alt_text ?? '',
        ];
    }
}
