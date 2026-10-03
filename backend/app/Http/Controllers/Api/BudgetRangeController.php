<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BudgetRangeResource;
use App\Models\BudgetRange;
use Illuminate\Http\JsonResponse;

class BudgetRangeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => BudgetRangeResource::collection(
                BudgetRange::where('is_active', true)->orderBy('sort_order')->get()
            ),
        ]);
    }
}
