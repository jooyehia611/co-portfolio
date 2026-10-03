<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('industry')->nullable()->after('client_name');
            $table->unsignedSmallInteger('year')->nullable()->after('industry');
            $table->longText('challenge')->nullable()->after('description');
            $table->longText('solution')->nullable()->after('challenge');
            $table->longText('approach')->nullable()->after('solution');
            $table->longText('design_notes')->nullable()->after('approach');
            $table->longText('development_notes')->nullable()->after('design_notes');
            $table->json('key_features')->nullable()->after('development_notes');
            $table->json('results')->nullable()->after('key_features');
            $table->string('timeline')->nullable()->after('results');
            $table->string('video_url')->nullable()->after('live_url');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->json('capabilities')->nullable()->after('description');
            $table->json('business_problems')->nullable()->after('capabilities');
        });

        Schema::table('technologies', function (Blueprint $table) {
            $table->string('category')->default('other')->after('description');
            $table->boolean('is_active')->default(true)->after('sort_order');
        });

        Schema::table('statistics', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('sort_order');
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'industry', 'year', 'challenge', 'solution', 'approach',
                'design_notes', 'development_notes', 'key_features', 'results',
                'timeline', 'video_url',
            ]);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['capabilities', 'business_problems']);
        });
    }
};
