<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Project::published()
            ->with(['coverImage', 'featuredImage', 'technologies', 'services']);

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        $projects = $query->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($projects),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $project = Project::published()
            ->with(['featuredImage', 'coverImage', 'technologies', 'services', 'gallery.mediaFile'])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Project::published()
            ->with(['coverImage', 'technologies'])
            ->where('id', '!=', $project->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        $data = (new ProjectResource($project))->toArray(request());
        $data['related_projects'] = ProjectResource::collection($related);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
