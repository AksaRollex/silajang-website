<?php

namespace Database\Seeders;

use App\Models\JenisWadah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisWadahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisWadah::create(['nama' => 'Plastik']);
        JenisWadah::create(['nama' => 'Gelas']);
    }
}
