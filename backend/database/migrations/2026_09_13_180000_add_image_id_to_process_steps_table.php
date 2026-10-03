<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('process_steps', function (Blueprint $table) {
            $table->foreignId('image_id')
                ->nullable()
                ->after('icon')
                ->constrained('media_files')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('process_steps', function (Blueprint $table) {
            $table->dropConstrainedForeignId('image_id');
        });
    }
};
