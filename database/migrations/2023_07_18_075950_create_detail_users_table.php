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
        Schema::create('detail_users', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('instansi');
            $table->string('alamat');
            $table->string('pimpinan');
            $table->string('pj_mutu');
            $table->string('telepon');
            $table->string('fax')->nullable();
            $table->string('email');
            $table->string('jenis_kegiatan');

            $table->string('lat')->nullable();
            $table->string('long')->nullable();

            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->restrictOnDelete();
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahans')->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_users');
    }
};
