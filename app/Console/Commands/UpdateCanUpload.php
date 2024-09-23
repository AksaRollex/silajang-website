<?php

namespace App\Console\Commands;

use App\Models\TitikPermohonan;
use Illuminate\Console\Command;

class UpdateCanUpload extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:update-can-upload';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Update the can_upload status of titik permohonan';

  /**
   * Execute the console command.
   */
  public function handle() {
    $affectedRows = TitikPermohonan::where('status', '>', 1)
      ->update(['can_upload' => 0]);
    $affectedRows = TitikPermohonan::whereIn('status', [6, 7])
      ->update(['can_upload' => 1]);

    $verifRows = TitikPermohonan::where('status', '>', 7)
      ->update(['verifikasi_lhu' => 1]);

    $sertiRows = TitikPermohonan::where('verifikasi_lhu', '=', 1)->where('sertifikat', '=', 0)
      ->update(['sertifikat' => 1]);

    $this->info("Can Upload: $affectedRows rows have been updated.");
    $this->info("Verif: $verifRows rows have been updated.");
    $this->info("Sertifikat: $sertiRows rows have been updated.");

    return 0;
  }
}
