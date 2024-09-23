<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::table('payments', function (Blueprint $table) {
      $table->enum("type", ["va", "qris"])->default("va")->after('uuid');
      $table->string("qris_value", 365)->nullable();
      $table->string("qris_number")->nullable();
      $table->string("qris_expired")->nullable();
    });

    DB::unprepared('ALTER TABLE payments MODIFY va_number VARCHAR(255) NULL;');
    DB::unprepared('ALTER TABLE payments MODIFY nama VARCHAR(255) NULL;');
    DB::unprepared('ALTER TABLE payments MODIFY tanggal_exp VARCHAR(255) NULL;');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::table('payments', function (Blueprint $table) {
      $table->dropColumn("qris_value");
      $table->dropColumn("qris_number");
      $table->dropColumn("qris_expired");
    });
  }
};
