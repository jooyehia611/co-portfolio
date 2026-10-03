<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->text('content')->nullable()->change();
            $table->string('audio_path')->nullable();
            $table->unsignedInteger('audio_duration')->nullable();
        });

        Schema::create('voice_review_invites', function (Blueprint $table) {
            $table->id();
            $table->string('token_hash', 64)->unique();
            $table->string('client_name')->nullable();
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voice_review_invites');
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['audio_path', 'audio_duration']);
            $table->text('content')->nullable(false)->change();
        });
    }
};
