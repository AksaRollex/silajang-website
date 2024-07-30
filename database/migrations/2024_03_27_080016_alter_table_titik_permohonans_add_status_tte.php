<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::table('titik_permohonans', function (Blueprint $table) {
      $table->boolean('status_tte_skrd')->nullable();
      $table->boolean('status_tte_kwitansi')->nullable();
      $table->boolean('status_tte_kendali_mutu')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::table('titik_permohonans', function (Blueprint $table) {
      //
    });
  }
};
