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
            $table->boolean('can_upload')->after('keterangan_revisi')->default(1)->nullable();
            $table->boolean('verifikasi_lhu')->after('can_upload')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titik_permohonans', function (Blueprint $table) {
            $table->dropColumn('can_upload');
            $table->dropColumn('verifikasi_lhu');
        });
    }
};
