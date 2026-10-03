<?php

namespace App\Http\Controllers\Api;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\VoiceReviewInvite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class VoiceReviewController extends Controller
{
    public function show(string $token): JsonResponse
    {
        $invite = $this->findValidInvite($token);

        return response()->json(['success' => true, 'data' => ['client_name' => $invite->client_name]]);
    }

    public function store(Request $request, string $token): JsonResponse
    {
        $data = $request->validate([
            'client_name' => ['required', 'string', 'max:120'],
            'client_title' => ['nullable', 'string', 'max:120'],
            'client_company' => ['nullable', 'string', 'max:120'],
            'audio' => ['required', 'file', 'mimes:webm,ogg,mp3,mp4,m4a,wav', 'max:10240'],
            'audio_duration' => ['nullable', 'integer', 'min:1', 'max:120'],
        ]);

        $path = null;
        try {
            DB::transaction(function () use ($request, $token, $data, &$path) {
                $invite = VoiceReviewInvite::where('token_hash', hash('sha256', $token))->lockForUpdate()->first();
                if (! $invite || $invite->used_at || $invite->expires_at->isPast()) {
                    throw ValidationException::withMessages(['link' => __('This recording link is no longer available.')]);
                }

                $path = $request->file('audio')->store('voice-reviews', 'public');
                Testimonial::create([
                    'client_name' => $data['client_name'],
                    'client_title' => $data['client_title'] ?? null,
                    'client_company' => $data['client_company'] ?? null,
                    'audio_path' => $path,
                    'audio_duration' => $data['audio_duration'] ?? null,
                    'status' => ContentStatus::Draft,
                    'is_featured' => true,
                    'rating' => 5,
                ]);
                $invite->update(['used_at' => now()]);
            });
        } catch (\Throwable $e) {
            if ($path) Storage::disk('public')->delete($path);
            throw $e;
        }

        return response()->json(['success' => true, 'message' => __('Your recording was received and is awaiting review.')], 201);
    }

    private function findValidInvite(string $token): VoiceReviewInvite
    {
        $invite = VoiceReviewInvite::where('token_hash', hash('sha256', $token))->first();
        abort_unless($invite && ! $invite->used_at && $invite->expires_at->isFuture(), 404);

        return $invite;
    }
}
