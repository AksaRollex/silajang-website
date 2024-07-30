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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('nama');
            $table->string('metode');
            $table->double('harga');
            $table->string('satuan')->nullable();
            $table->string('mdl')->nullable();
            $table->boolean('is_akreditasi')->default(false);
            $table->boolean('is_dapat_diuji')->default(true);
            $table->foreignId('jenis_parameter_id')->constrained('jenis_parameters')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
