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
            $table->boolean('kesimpulan_sampel')->nullable()->comment('Diterima atau ditolak');
            $table->boolean('kondisi_sampel')->nullable()->comment('Normal atau abnormal');
            $table->string('keterangan_kondisi_sampel')->nullable()->comment('Keterangan kondisi sampel, jelaskan...');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titik_permohonans', function (Blueprint $table) {
            //
        });
    }
};
