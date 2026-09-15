<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->string('audio_path')->nullable()->after('image_path');
            $table->string('audio_source')->default('auto')->after('audio_path');
            $table->string('audio_voice')->default('male')->after('audio_source');
        });
    }

    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn(['audio_path', 'audio_source', 'audio_voice']);
        });
    }
};
