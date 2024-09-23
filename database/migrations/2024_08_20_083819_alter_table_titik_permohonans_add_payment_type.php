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
      $table->enum('payment_type', ['va', 'qris'])->default('va');
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
