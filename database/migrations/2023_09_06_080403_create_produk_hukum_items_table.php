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
        Schema::create('produk_hukum_items', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('produk_hukum_id')->constrained('produk_hukums')->cascadeOnDelete();
            $table->string('nama');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_hukum_items');
    }
};
