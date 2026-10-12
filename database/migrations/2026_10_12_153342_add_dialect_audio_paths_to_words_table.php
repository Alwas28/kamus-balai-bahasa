<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->string('audio_konawe_path')->nullable()->after('audio_path');
            $table->string('audio_mekongga_path')->nullable()->after('audio_konawe_path');
        });
    }

    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn(['audio_konawe_path', 'audio_mekongga_path']);
        });
    }
};
