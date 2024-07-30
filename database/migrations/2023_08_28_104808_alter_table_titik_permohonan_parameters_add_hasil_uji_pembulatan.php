<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('titik_permohonan_parameters', function (Blueprint $table) {
            $table->string('hasil_uji_pembulatan')->nullable()->after('hasil_uji');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titik_permohonan_parameters', function (Blueprint $table) {
            $table->dropColumn('hasil_uji_pembulatan');
        });
    }
};
