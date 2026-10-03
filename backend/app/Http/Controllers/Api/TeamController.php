<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamMemberResource;
use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    public function index(): JsonResponse
    {
        $members = TeamMember::with('photo')->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => TeamMemberResource::collection($members),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $member = TeamMember::with('photo')->where('slug', $slug)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new TeamMemberResource($member),
        ]);
    }
}
