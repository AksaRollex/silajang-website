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
        Schema::create('umpan_baliks', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('nomer');
            $table->string('tahun');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->integer('u1');
            $table->string('keterangan_u1')->nullable();

            $table->integer('u2');
            $table->string('keterangan_u2')->nullable();

            $table->integer('u3');
            $table->string('keterangan_u3')->nullable();

            $table->integer('u4');
            $table->string('keterangan_u4')->nullable();

            $table->integer('u5');
            $table->string('keterangan_u5')->nullable();

            $table->integer('u6');
            $table->string('keterangan_u6')->nullable();

            $table->integer('u7');
            $table->string('keterangan_u7')->nullable();

            $table->integer('u8');
            $table->string('keterangan_u8')->nullable();

            $table->integer('u9');
            $table->string('keterangan_u9')->nullable();

            $table->integer('u10');
            $table->string('keterangan_u10')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umpan_baliks');
    }
};
