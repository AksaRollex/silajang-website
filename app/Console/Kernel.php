<?php

namespace App\Console;

use App\Models\Kontrak;
use App\Models\Permohonan;
use App\Models\TitikPermohonan;
use App\Models\TrackingPengujian;
use App\Models\TitikPermohonanParameter;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            $permohonans = Permohonan::with('kontrak', 'titikPermohonans.parameters', 'titikPermohonans.jenisWadahs')->where('kesimpulan_kontrak', 1)->whereNotNull('kontrak_id')->whereHas('kontrak', function ($q) {$q->where('bulan', 'like', '%' . date('n') . '%');$q->where('created_at', 'like', '%' . date('Y') . '%');})->whereHas('titikPermohonans', function ($q) {$q->where('save_parameter', 1);$q->where('kesimpulan_permohonan', 1);})->get();

            foreach ($permohonans as $permohonan) {if(Carbon::parse($permohonan->kontrak->created_at)->format('m-Y') != Carbon::now()->format('m-Y')) {foreach ($permohonan->titikPermohonans as $titik) {$newTitik = $titik->replicate();$newTitik->kode = '(Belum Ditetapkan)';$newTitik->no_lhu = '(Belum Ditetapkan)';$newTitik->no_formulir = '(Belum Ditetapkan)';$newTitik->permohonan_id = $titik->permohonan_id;$newTitik->jenis_sampel_id = $titik->jenis_sampel_id;$newTitik->jenis_wadah_id = null;$newTitik->peraturan_id = $titik->peraturan_id;$newTitik->pengambil_id = null;$newTitik->nama_pengambil = null;$newTitik->tanggal_pengambilan = null;if ($newTitik->is_mandiri) {$newTitik->status = 1;} else {$newTitik->status = 0;}$newTitik->keterangan_revisi = null;$newTitik->status_pembayaran = 0;$newTitik->sertifikat = 0;$newTitik->tanggal_diterima = null;$newTitik->tanggal_selesai = null;$newTitik->tanggal_tte = null;$newTitik->acuan_metode_id = null;$newTitik->baku_mutu = null;$newTitik->hasil_pengujian = null;$newTitik->memenuhi_hasil_pengujian = null;$newTitik->kesimpulan_permohonan = null;$newTitik->lab_subkontrak = null;$newTitik->kesimpulan_sampel = null;$newTitik->kondisi_sampel = null;$newTitik->keterangan_kondisi_sampel = null;$newTitik->pengawetan_oleh = null;$newTitik->obyek_pelayanan = null;$newTitik->file_lhu = null;$newTitik->save_parameter = 1;$newTitik->user_has_va = 0;$newTitik->status_tte = null;$newTitik->status_tte_skrd = null;$newTitik->status_tte_kwitansi = null;$newTitik->status_tte_kendali_mutu = null;$newTitik->save();foreach ($titik->jenisWadahs as $wadah) {$newTitik->jenisWadahs()->attach($wadah->id);}foreach ($titik->parameters as $param) {$newTitik->parameters()->attach($param->id, ['harga' => $param->pivot->harga, 'satuan' => $param->pivot->satuan,'baku_mutu' => null,'mdl' => $param->pivot->mdl,'hasil_uji' => null,'hasil_uji_pembulatan' => null,'keterangan' => null,'keterangan_hasil' => null,'kuantitas' => $param->pivot->kuantitas,'acc_analis' => 0,'acc_analis_at' => null,'acc_manager' => 0,'acc_manager_at' => null,'personel' => null,'metode' => null,'peralatan' => null,'reagen' => null,'akomodasi' => null,'beban_kerja' => null,]);}}}}
        })->monthly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
