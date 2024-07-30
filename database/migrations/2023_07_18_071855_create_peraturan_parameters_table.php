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
        Schema::create('peraturan_parameters', function (Blueprint $table) {
            $table->id();
            // $table->uuid()->unique();
            $table->foreignId('peraturan_id')->constrained('peraturans')->cascadeOnDelete();
            $table->foreignId('parameter_id')->constrained('parameters')->cascadeOnDelete();
            $table->string('baku_mutu')->nullable();
            $table->boolean('cetak_miring')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peraturan_parameters');
    }
};
