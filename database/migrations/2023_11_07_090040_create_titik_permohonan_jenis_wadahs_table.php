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
        Schema::create('titik_permohonan_jenis_wadahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('titik_permohonan_id')->constrained('titik_permohonans')->cascadeOnDelete();
            $table->foreignId('jenis_wadah_id')->constrained('jenis_wadahs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik_permohonan_jenis_wadahs');
    }
};
