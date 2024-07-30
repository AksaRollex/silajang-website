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
        Schema::table('umpan_baliks', function (Blueprint $table) {
            $table->dropColumn('u10');
            $table->dropColumn('keterangan_u10');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umpan_baliks', function (Blueprint $table) {
            //
        });
    }
};
