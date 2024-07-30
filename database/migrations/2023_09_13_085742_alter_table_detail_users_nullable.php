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
        Schema::table('detail_users', function (Blueprint $table) {
            $table->string('instansi')->nullable()->change();
            $table->string('alamat')->nullable()->change();
            $table->string('pimpinan')->nullable()->change();
            $table->string('pj_mutu')->nullable()->change();
            $table->string('telepon')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('jenis_kegiatan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_users', function (Blueprint $table) {
            //
        });
    }
};
