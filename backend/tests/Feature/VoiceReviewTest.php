<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Models\Testimonial;
use App\Models\VoiceReviewInvite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VoiceReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_voice_review_is_saved_as_draft_and_invite_can_only_be_used_once(): void
    {
        Storage::fake('public');
        $token = bin2hex(random_bytes(32));
        VoiceReviewInvite::create([
            'token_hash' => hash('sha256', $token),
            'client_name' => 'Client',
            'expires_at' => now()->addDay(),
        ]);

        $this->getJson("/api/v1/voice-reviews/{$token}")->assertOk()->assertJsonPath('data.client_name', 'Client');

        // A minimal valid PCM WAV file lets MIME validation inspect real audio data.
        $wav = 'RIFF'.pack('V', 36).'WAVEfmt '.pack('VvvVVvv', 16, 1, 1, 8000, 16000, 2, 16).'data'.pack('V', 0);
        $payload = ['client_name' => 'Client', 'audio_duration' => 1, 'audio' => UploadedFile::fake()->createWithContent('review.wav', $wav)];
        $this->postJson("/api/v1/voice-reviews/{$token}", $payload)->assertCreated();

        $review = Testimonial::firstOrFail();
        $this->assertSame(ContentStatus::Draft, $review->status);
        $this->assertNotNull($review->audio_path);
        Storage::disk('public')->assertExists($review->audio_path);
        $this->postJson("/api/v1/voice-reviews/{$token}", $payload)->assertUnprocessable();
        $this->getJson("/api/v1/voice-reviews/{$token}")->assertNotFound();
        $this->getJson('/api/v1/testimonials')->assertJsonCount(0, 'data');

        $review->update(['status' => ContentStatus::Published]);
        $this->getJson('/api/v1/testimonials')->assertJsonCount(1, 'data')->assertJsonPath('data.0.client_name', 'Client');
    }
}
