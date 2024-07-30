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
        Schema::table('titik_permohonans', function (Blueprint $table) {
            $table->boolean('hasil_pengujian')->nullable(); // Ternyata terdapat 4 kondisi, jadi 0 1 2 3 (Tidak Ada, Ada, Memenuhi Persyaratan, Tidak Memenuhi Persyaratan)
            $table->boolean('kesimpulan_permohonan')->nullable()->comment('Diterima atau ditolak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titik_permohonans', function (Blueprint $table) {
            $table->dropColumn('hasil_pengujian');
            $table->dropColumn('kesimpulan_permohonan');
        });
    }
};
