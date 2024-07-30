<?php

namespace Database\Seeders;

use App\Models\TitikPermohonan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TitikPermohonanJenisWadahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titikPermohonans = TitikPermohonan::get();
        foreach ($titikPermohonans as $titik) {
            $titik->jenisWadahs()->sync([$titik->jenis_wadah_id]);
        }
    }
}
