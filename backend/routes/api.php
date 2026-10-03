<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SeoController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TechnologyController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\VoiceReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/health', fn () => response()->json(['status' => 'ok']));

    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::get('/about', [AboutController::class, 'index']);

    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{slug}', [ServiceController::class, 'show']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{slug}', [ProjectController::class, 'show']);

    Route::get('/technologies', [TechnologyController::class, 'index']);
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/voice-reviews/{token}', [VoiceReviewController::class, 'show'])->where('token', '[a-f0-9]{64}')->middleware('throttle:voice-review');
    Route::post('/voice-reviews/{token}', [VoiceReviewController::class, 'store'])->where('token', '[a-f0-9]{64}')->middleware('throttle:voice-review');

    Route::get('/team', [TeamController::class, 'index']);
    Route::get('/team/{slug}', [TeamController::class, 'show']);

    Route::get('/contact/form-data', [ContactController::class, 'formData']);
    Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact');

    Route::get('/pages/privacy', [PageController::class, 'privacy']);
    Route::get('/pages/terms', [PageController::class, 'terms']);

    Route::get('/seo/{key}', [SeoController::class, 'page']);
});
