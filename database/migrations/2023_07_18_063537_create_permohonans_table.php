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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->text('keterangan')->nullable();
            $table->string('industri', 255);
            $table->string('kegiatan', 255);
            $table->string('alamat', 255);

            $table->enum('pembayaran', ['tunai', 'transfer'])->default('tunai');
            $table->boolean('is_mandiri')->default(false);

            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('jasa_pengambilan_id')->nullable()->constrained('jasa_pengambilans')->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
