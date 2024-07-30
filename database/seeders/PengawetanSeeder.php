<?php

namespace Database\Seeders;

use App\Models\Pengawetan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengawetanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengawetan::create(['id' => 1, 'nama' => 'Pendinginan']);
        Pengawetan::create(['id' => 2, 'nama' => 'H2SO4']);
        Pengawetan::create(['id' => 3, 'nama' => 'HNO3']);
        Pengawetan::create(['id' => 4, 'nama' => 'NaOH']);
        Pengawetan::create(['id' => 5, 'nama' => 'Zn(CH3COO)2']);
        Pengawetan::create(['id' => 6, 'nama' => '(NH4)2SO4']);
    }
}
