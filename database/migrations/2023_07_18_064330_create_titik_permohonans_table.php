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
        Schema::create('titik_permohonans', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('kode');
            $table->string('lokasi');
            $table->string('south');
            $table->string('east');
            $table->string('keterangan')->nullable();
            $table->foreignId('permohonan_id')->constrained('permohonans')->restrictOnDelete();
            $table->foreignId('jenis_sampel_id')->constrained('jenis_sampels')->restrictOnDelete();
            $table->foreignId('jenis_wadah_id')->constrained('jenis_wadahs')->restrictOnDelete();

            $table->foreignId('peraturan_id')->nullable()->constrained('peraturans')->restrictOnDelete();
            $table->foreignId('pengambil_id')->nullable()->constrained('users')->restrictOnDelete(); // Jika is_mandiri = false
            $table->string('nama_pengambil')->nullable(); // Jika is_mandiri = true
            $table->dateTime('tanggal_pengambilan')->nullable();

            $table->integer('status')->default(0);
            $table->integer('status_pembayaran')->default(0);
            $table->boolean('sertifikat')->default(false);

            $table->date('tanggal_diterima')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik_permohonans');
    }
};
