<?php

namespace Database\Seeders;

use App\Models\KeteranganUmpanBalik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeteranganUmpanBalikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('keterangan_umpan_baliks')->truncate();

        KeteranganUmpanBalik::create(['kode' => 'u1', 'keterangan' => 'Kemudahan Prosedur Pelayanan']);
        KeteranganUmpanBalik::create(['kode' => 'u2', 'keterangan' => 'Kesesuaian Persyaratan Pengujian Pelayanan']);
        KeteranganUmpanBalik::create(['kode' => 'u3', 'keterangan' => 'Ketepatan Waktu Penyesuaian Sertifikat Uji']);
        KeteranganUmpanBalik::create(['kode' => 'u4', 'keterangan' => 'Biaya Pengujian']);
        KeteranganUmpanBalik::create(['kode' => 'u5', 'keterangan' => 'Kemudahan Mekanisme Pembayaran']);
        KeteranganUmpanBalik::create(['kode' => 'u6', 'keterangan' => 'Kesesuaian Hasil Pengujian Sample']);
        KeteranganUmpanBalik::create(['kode' => 'u7', 'keterangan' => 'Kemampuan Petugas dalam Memberikan Pelayanan']);
        KeteranganUmpanBalik::create(['kode' => 'u8', 'keterangan' => 'Kecepatan Penanganan Pengaduan']);
        KeteranganUmpanBalik::create(['kode' => 'u9', 'keterangan' => 'Kesopanan dan Keramahan Petugas']);
        // KeteranganUmpanBalik::create(['kode' => 'u10', 'keterangan' => 'Fasilitas Pelayanan Yang Disediakan']);
    }
}
