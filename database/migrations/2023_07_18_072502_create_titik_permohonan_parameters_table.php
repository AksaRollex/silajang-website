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
        Schema::create('titik_permohonan_parameters', function (Blueprint $table) {
            $table->id();
            // $table->uuid()->unique();
            $table->foreignId('titik_permohonan_id')->constrained('titik_permohonans')->cascadeOnDelete();
            $table->foreignId('parameter_id')->constrained('parameters')->cascadeOnDelete();

            $table->string('harga');
            $table->string('satuan')->nullable();
            $table->string('baku_mutu')->nullable();
            $table->string('mdl')->nullable();
            $table->string('hasil_uji')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('kuantitas');

            $table->boolean('acc_analis')->default(false);
            $table->dateTime('acc_analis_at')->nullable();

            $table->boolean('acc_manager')->default(false);
            $table->dateTime('acc_manager_at')->nullable();

            $table->boolean('acc_upt')->default(false);
            $table->dateTime('acc_upt_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik_permohonan_parameters');
    }
};
