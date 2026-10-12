<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->string('audio_konawe_source')->default('auto')->after('audio_voice');
            $table->string('audio_konawe_voice')->default('male')->after('audio_konawe_source');
            $table->string('audio_mekongga_source')->default('auto')->after('audio_konawe_voice');
            $table->string('audio_mekongga_voice')->default('male')->after('audio_mekongga_source');
        });

        // Previously one source/voice applied to every language: carry it over per language.
        DB::table('words')->update([
            'audio_konawe_voice' => DB::raw('audio_voice'),
            'audio_mekongga_voice' => DB::raw('audio_voice'),
        ]);
        DB::table('words')->whereNotNull('audio_konawe_path')->update(['audio_konawe_source' => 'local']);
        DB::table('words')->whereNotNull('audio_mekongga_path')->update(['audio_mekongga_source' => 'local']);
        DB::table('words')->where('audio_source', 'local')->whereNull('audio_path')->update(['audio_source' => 'auto']);
    }

    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn(['audio_konawe_source', 'audio_konawe_voice', 'audio_mekongga_source', 'audio_mekongga_voice']);
        });
    }
};
