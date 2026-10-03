<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('year', 10);
            // Translatable payloads are stored as JSON via TranslationCast.
            $table->json('title');
            $table->json('platform')->nullable();
            $table->json('result')->nullable();
            $table->string('link_url')->nullable();
            $table->foreignId('logo_id')->nullable()->constrained('media_files')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('awards');
    }
};
