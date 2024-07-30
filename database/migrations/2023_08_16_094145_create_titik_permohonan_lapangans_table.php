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
        Schema::create('titik_permohonan_lapangans', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('titik_permohonan_id')->constrained('titik_permohonans')->cascadeOnDelete();
            $table->string('suhu_air')->nullable();
            $table->string('ph')->nullable();
            $table->string('dhl')->nullable();
            $table->string('salinitas')->nullable();
            $table->string('do')->nullable();
            $table->string('suhu_udara')->nullable();
            $table->string('kelembapan')->nullable();
            $table->string('cuaca')->nullable();
            $table->string('kecepatan_angin')->nullable();
            $table->string('arah_angin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik_permohonan_lapangans');
    }
};
