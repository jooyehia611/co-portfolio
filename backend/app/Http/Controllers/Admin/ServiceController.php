<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\Service;
use App\Services\MediaService;
use App\Support\Translator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function __construct(private MediaService $mediaService) {}

    public function index()
    {
        return view('admin.services.index', ['items' => Service::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.services.form', ['item' => new Service, 'statuses' => ContentStatus::cases()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']['en'] ?? $data['title']['ar'] ?? 'service');
        $service = Service::create($data);
        $this->syncFeaturedImage($request, $service);

        return redirect()->route('admin.services.index')->with('success', __('admin.messages.service_created'));
    }

    public function edit(Service $service)
    {
        $service->load('featuredImage');

        return view('admin.services.form', ['item' => $service, 'statuses' => ContentStatus::cases()]);
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']['en'] ?? $data['title']['ar'] ?? $service->slug);
        $service->update($data);
        $this->syncFeaturedImage($request, $service);

        return redirect()->route('admin.services.index')->with('success', __('admin.messages.service_updated'));
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', __('admin.messages.service_deleted'));
    }

    private function validated(Request $request): array
    {
        $request->validate([
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'featured_image_alt' => 'nullable|string|max:255',
            'remove_featured_image' => 'boolean',
        ]);

        $data = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'short_description_ar' => 'nullable|string',
            'short_description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'capabilities_ar' => 'nullable|string',
            'capabilities_en' => 'nullable|string',
            'business_problems_ar' => 'nullable|string',
            'business_problems_en' => 'nullable|string',
            'is_featured' => 'boolean',
            'status' => 'required|string',
            'sort_order' => 'integer|min:0',
            'meta_title_ar' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_ar' => 'nullable|string',
            'meta_description_en' => 'nullable|string',
        ]);

        $data = Translator::mergeFromRequest($data, [
            'title', 'short_description', 'description', 'meta_title', 'meta_description',
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['capabilities'] = $this->bilingualLines(
            $request,
            'capabilities',
            $request->route('service')?->capabilities
        );
        $data['business_problems'] = $this->bilingualLines(
            $request,
            'business_problems',
            $request->route('service')?->business_problems
        );

        return $data;
    }

    private function bilingualLines(Request $request, string $name, ?array $existing): ?array
    {
        if (! $request->exists("{$name}_ar") && ! $request->exists("{$name}_en")) {
            return $existing;
        }

        $ar = $this->splitLines($request->input("{$name}_ar"));
        $en = $this->splitLines($request->input("{$name}_en"));

        if ($ar === [] && $en === []) {
            return $existing;
        }

        return [
            'ar' => $ar !== [] ? $ar : $en,
            'en' => $en !== [] ? $en : $ar,
        ];
    }

    private function splitLines(mixed $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value) ?: [])
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    private function syncFeaturedImage(Request $request, Service $service): void
    {
        if ($request->boolean('remove_featured_image')) {
            $service->update(['featured_image_id' => null]);

            return;
        }

        if ($request->hasFile('featured_image')) {
            $media = $this->mediaService->upload(
                $request->file('featured_image'),
                $request->input('featured_image_alt'),
                'services'
            );
            $service->update(['featured_image_id' => $media->id]);

            return;
        }

        if ($service->featured_image_id && $request->filled('featured_image_alt')) {
            MediaFile::whereKey($service->featured_image_id)->update([
                'alt_text' => $request->input('featured_image_alt'),
            ]);
        }
    }
}
