<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::table('permohonans', function (Blueprint $table) {
      $table->boolean('kesimpulan_kontrak')->nullable()->default(1);
      $table->foreignId('kontrak_id')->nullable()->constrained('kontraks')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    //
  }
};
