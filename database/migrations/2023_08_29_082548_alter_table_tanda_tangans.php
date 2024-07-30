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
        Schema::table('tanda_tangans', function (Blueprint $table) {
            $table->dropColumn('nama');
            $table->dropColumn('jabatan');
            $table->dropColumn('nip');

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tanda_tangans', function (Blueprint $table) {
            $table->string('nama')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('nip')->nullable();

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
