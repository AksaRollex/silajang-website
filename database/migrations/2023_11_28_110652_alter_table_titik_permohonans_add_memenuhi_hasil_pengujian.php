<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('titik_permohonans', function (Blueprint $table) {
            $table->tinyInteger('memenuhi_hasil_pengujian')->nullable()->after('hasil_pengujian');
        });

        DB::unprepared('UPDATE titik_permohonans SET memenuhi_hasil_pengujian = 1 WHERE hasil_pengujian = 2');
        DB::unprepared('UPDATE titik_permohonans SET memenuhi_hasil_pengujian = 0 WHERE hasil_pengujian = 3');

        DB::unprepared('UPDATE titik_permohonans SET hasil_pengujian = 1 WHERE hasil_pengujian = 2');
        DB::unprepared('UPDATE titik_permohonans SET hasil_pengujian = 0 WHERE hasil_pengujian = 3');
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
