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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('kode_retribusi_id')->nullable()->constrained('kode_retribusis')->onDelete('restrict');
            $table->string('va_number')->unique();
            $table->string('nama');
            $table->double('jumlah');
            $table->string('tanggal_exp')->comment('YYYYMMDD');
            $table->boolean('is_lunas')->default(false);
            $table->foreignId('titik_permohonan_id')->nullable()->constrained('titik_permohonans')->onDelete('restrict');

            $table->text('berita1')->nullable();
            $table->text('berita2')->nullable();
            $table->text('berita3')->nullable();
            $table->text('berita4')->nullable();
            $table->text('berita5')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
