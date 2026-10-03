<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeoPageResource;
use App\Models\Project;
use App\Models\SeoPage;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function page(string $key): JsonResponse
    {
        $page = SeoPage::with('ogImage')->where('page_key', $key)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new SeoPageResource($page),
        ]);
    }

    public function sitemap(): Response
    {
        $baseUrl = config('app.url');
        $urls = [];

        SeoPage::where('is_indexable', true)->get()->each(function ($page) use (&$urls, $baseUrl) {
            $urls[] = ['loc' => $baseUrl.'/'.($page->slug ?? $page->page_key), 'priority' => '0.8'];
        });

        Service::published()->get(['slug'])->each(function ($s) use (&$urls, $baseUrl) {
            $urls[] = ['loc' => $baseUrl.'/services/'.$s->slug, 'priority' => '0.7'];
        });

        Project::published()->get(['slug'])->each(function ($p) use (&$urls, $baseUrl) {
            $urls[] = ['loc' => $baseUrl.'/projects/'.$p->slug, 'priority' => '0.7'];
        });

        $xml = view('sitemap', compact('urls', 'baseUrl'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nSitemap: ".config('app.url')."/sitemap.xml\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
