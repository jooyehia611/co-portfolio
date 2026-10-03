<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Technology;
use App\Services\MediaService;
use App\Support\FeatureGroups;
use App\Support\Translator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function __construct(private MediaService $mediaService) {}

    public function index()
    {
        return view('admin.projects.index', ['items' => Project::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.projects.form', [
            'item' => new Project,
            'statuses' => ContentStatus::cases(),
            'services' => Service::orderBy('sort_order')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']['en'] ?? $data['title']['ar'] ?? 'project');
        $project = Project::create($data);
        $project->services()->sync($request->input('services', []));
        $project->technologies()->sync($request->input('technologies', []));
        $this->syncProjectImages($request, $project);

        return redirect()->route('admin.projects.index')->with('success', __('admin.messages.project_created'));
    }

    public function edit(Project $project)
    {
        $project->load(['coverImage', 'featuredImage', 'services', 'technologies']);

        return view('admin.projects.form', [
            'item' => $project,
            'statuses' => ContentStatus::cases(),
            'services' => Service::orderBy('sort_order')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']['en'] ?? $data['title']['ar'] ?? $project->slug);
        $project->update($data);
        $project->services()->sync($request->input('services', []));
        $project->technologies()->sync($request->input('technologies', []));
        $this->syncProjectImages($request, $project);

        return redirect()->route('admin.projects.index')->with('success', __('admin.messages.project_updated'));
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('success', __('admin.messages.project_deleted'));
    }

    public function updateStatus(Request $request, Project $project)
    {
        $data = $request->validate([
            'status' => 'required|string|in:'.implode(',', array_column(ContentStatus::cases(), 'value')),
        ]);

        $project->update(['status' => $data['status']]);

        return back()->with('success', __('admin.messages.project_updated'));
    }

    private function validated(Request $request): array
    {
        $request->validate([
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'cover_image_alt' => 'nullable|string|max:255',
            'featured_image_alt' => 'nullable|string|max:255',
            'remove_cover_image' => 'boolean',
            'remove_featured_image' => 'boolean',
        ]);

        $data = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'short_description_ar' => 'nullable|string',
            'short_description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'challenge_ar' => 'nullable|string',
            'challenge_en' => 'nullable|string',
            'solution_ar' => 'nullable|string',
            'solution_en' => 'nullable|string',
            'live_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'status' => 'required|string',
            'sort_order' => 'integer|min:0',
            'meta_title_ar' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_ar' => 'nullable|string',
            'meta_description_en' => 'nullable|string',
        ]);

        $data = Translator::mergeFromRequest($data, [
            'title', 'short_description', 'description', 'challenge', 'solution',
            'meta_title', 'meta_description',
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['key_features'] = FeatureGroups::parseRequest($request->input('feature_groups', []));

        return $data;
    }

    private function syncProjectImages(Request $request, Project $project): void
    {
        $updates = [];

        if ($request->boolean('remove_cover_image')) {
            $updates['cover_image_id'] = null;
        } elseif ($request->hasFile('cover_image')) {
            $media = $this->mediaService->upload(
                $request->file('cover_image'),
                $request->input('cover_image_alt'),
                'projects'
            );
            $updates['cover_image_id'] = $media->id;
        } elseif ($project->cover_image_id && $request->filled('cover_image_alt')) {
            MediaFile::whereKey($project->cover_image_id)->update([
                'alt_text' => $request->input('cover_image_alt'),
            ]);
        }

        if ($request->boolean('remove_featured_image')) {
            $updates['featured_image_id'] = null;
        } elseif ($request->hasFile('featured_image')) {
            $media = $this->mediaService->upload(
                $request->file('featured_image'),
                $request->input('featured_image_alt'),
                'projects'
            );
            $updates['featured_image_id'] = $media->id;
        } elseif ($project->featured_image_id && $request->filled('featured_image_alt')) {
            MediaFile::whereKey($project->featured_image_id)->update([
                'alt_text' => $request->input('featured_image_alt'),
            ]);
        }

        if ($updates !== []) {
            $project->update($updates);
        }
    }
}
