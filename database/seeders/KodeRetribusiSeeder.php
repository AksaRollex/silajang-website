<?php

namespace Database\Seeders;

use App\Models\KodeRetribusi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KodeRetribusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KodeRetribusi::create([
            'kode' => '01',
            'nama' => 'RETRIBUSI PERSAMPAHAN KEBERSIHAN',
        ]);
        KodeRetribusi::create([
            'kode' => '02',
            'nama' => 'RETRIBUSI PEMAKAIAN LAB',
        ]);
        KodeRetribusi::create([
            'kode' => '03',
            'nama' => 'RETRIBUSI PENYEWAAN TANAH & BANGUNAN',
        ]);
    }
}
