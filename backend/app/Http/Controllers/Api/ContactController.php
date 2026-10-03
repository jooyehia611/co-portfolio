<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function __construct(private ContactService $contactService) {}

    public function formData(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'services' => ServiceResource::collection(
                    Service::published()->orderBy('sort_order')->get(['id', 'title', 'slug'])
                ),
            ],
        ]);
    }

    public function store(ContactFormRequest $request): JsonResponse
    {
        $this->contactService->storeLead(
            $request->validated(),
            $request->ip(),
            $request->userAgent()
        );

        return response()->json([
            'success' => true,
            'message' => __('contact.success'),
        ], 201);
    }
}
