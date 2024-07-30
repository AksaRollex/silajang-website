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
        Schema::table('titik_permohonan_lapangans', function (Blueprint $table) {
            $table->string('kekeruhan')->nullable()->after('do');
            $table->string('klorin_bebas')->nullable()->after('kekeruhan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titik_permohonan_lapangans', function (Blueprint $table) {
            //
        });
    }
};
