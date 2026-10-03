<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessValueResource;
use App\Http\Resources\ProcessStepResource;
use App\Http\Resources\SeoPageResource;
use App\Http\Resources\StatisticResource;
use App\Http\Resources\TeamMemberResource;
use App\Http\Resources\TechnologyResource;
use App\Models\BusinessValue;
use App\Models\HomepageSection;
use App\Models\ProcessStep;
use App\Models\SeoPage;
use App\Models\Statistic;
use App\Models\TeamMember;
use App\Models\Technology;
use App\Services\SettingsService;
use App\Support\Translator;
use Illuminate\Http\JsonResponse;

class AboutController extends Controller
{
    public function __construct(private SettingsService $settingsService) {}

    public function index(): JsonResponse
    {
        $seoPage = SeoPage::where('page_key', 'about')->first();
        $sections = HomepageSection::whereIn('section_key', ['team', 'process', 'business_values'])
            ->get()
            ->keyBy('section_key');
        $processContent = $sections->get('process')?->content ?? [];

        $team = TeamMember::with('photo')->where('is_active', true)->orderBy('sort_order')->get();
        if ($team->isEmpty()) {
            $team = TeamMember::with('photo')->orderBy('sort_order')->get();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'hero' => [
                    'title' => __('about.hero.title'),
                    'description' => $this->settingsService->get('tagline', '') ?: __('about.hero.description'),
                ],
                'story' => [
                    'title' => __('about.story'),
                    'content' => $this->settingsService->get('about_summary', ''),
                ],
                'mission' => [
                    'title' => __('about.mission'),
                    'content' => $this->settingsService->get('about_mission', ''),
                ],
                'vision' => [
                    'title' => __('about.vision'),
                    'content' => $this->settingsService->get('about_vision', ''),
                ],
                'values' => BusinessValueResource::collection(
                    BusinessValue::orderBy('sort_order')->get()
                ),
                'values_section' => [
                    'title' => $sections->get('business_values')?->translate('title') ?? __('about.values'),
                    'subtitle' => $sections->get('business_values')?->translate('subtitle') ?? __('about.valuesEyebrow'),
                ],
                'team' => TeamMemberResource::collection($team),
                'team_section' => [
                    'title' => $sections->get('team')?->translate('title') ?? __('about.team'),
                    'subtitle' => $sections->get('team')?->translate('subtitle') ?? __('about.teamEyebrow'),
                    'description' => Translator::get($sections->get('team')?->content['description'] ?? null),
                ],
                'statistics' => StatisticResource::collection(
                    Statistic::where('is_active', true)->orderBy('sort_order')->get()
                ),
                'process_steps' => ProcessStepResource::collection(
                    ProcessStep::with('image')->orderBy('sort_order')->get()
                ),
                'process_section' => [
                    'title' => $sections->get('process')?->translate('title') ?? __('about.process'),
                    'subtitle' => $sections->get('process')?->translate('subtitle') ?? __('about.processEyebrow'),
                    'description' => Translator::get($processContent['description'] ?? null),
                    'button_label' => Translator::get($processContent['cta_label'] ?? null),
                    'button_href' => $processContent['cta_url'] ?? '/about',
                ],
                'technologies' => TechnologyResource::collection(
                    Technology::with('logo')->where('is_active', true)->orderBy('sort_order')->get()
                ),
                'seo' => $seoPage ? (new SeoPageResource($seoPage))->toArray(request()) : null,
            ],
        ]);
    }
}
