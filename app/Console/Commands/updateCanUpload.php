<?php

namespace App\Console\Commands;

use App\Models\TitikPermohonan;
use Illuminate\Console\Command;

class updateCanUpload extends Command
{
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
    public function handle()
    {
        $affectedRows = TitikPermohonan::where('status', '>', 5)
        ->update(['can_upload' => 0]);

        $verifRows = TitikPermohonan::where('status', '>', 7)
        ->update(['verifikasi_lhu' => 1]);

        $sertiRows = TitikPermohonan::where('verifikasi_lhu', '=', 1)->where('sertifikat', '=', 0)
        ->update(['sertifikat' => 1]);
    
    $this->info("$affectedRows rows have been updated.");
    $this->info("$verifRows rows have been updated.");
    $this->info("$sertiRows rows have been updated.");

    return 0;
    }
}
