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
        Schema::create('log_t_t_e_s', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('titik_permohonan_id')->constrained('titik_permohonans')->onDelete('cascade');
            $table->string('nik');
            $table->enum('status', ['success', 'error']);
            $table->longText('message');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_t_t_e_s');
    }
};
