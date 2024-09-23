<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('multi_payments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
      $table->foreignId('titik_permohonan_id')->constrained('titik_permohonans')->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('multi_payments');
  }
};
