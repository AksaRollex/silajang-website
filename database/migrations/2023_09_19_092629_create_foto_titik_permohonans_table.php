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
        Schema::create('foto_titik_permohonans', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('titik_permohonan_id')->constrained('titik_permohonans')->cascadeOnDelete();
            $table->string('foto');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_titik_permohonans');
    }
};
