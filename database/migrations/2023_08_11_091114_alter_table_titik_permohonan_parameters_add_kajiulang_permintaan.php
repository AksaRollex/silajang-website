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
        Schema::table('titik_permohonan_parameters', function (Blueprint $table) {
            $table->boolean('personel')->nullable();
            $table->boolean('metode')->nullable();
            $table->boolean('peralatan')->nullable();
            $table->boolean('reagen')->nullable();
            $table->boolean('akomodasi')->nullable();
            $table->boolean('beban_kerja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titik_permohonan_parameters', function (Blueprint $table) {
            $table->dropColumn('personel');
            $table->dropColumn('metode');
            $table->dropColumn('peralatan');
            $table->dropColumn('reagen');
            $table->dropColumn('akomodasi');
            $table->dropColumn('beban_kerja');
        });
    }
};
