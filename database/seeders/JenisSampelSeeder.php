<?php

namespace Database\Seeders;

use App\Models\JenisSampel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSampelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisSampel::create(['nama' => 'Air Limbah', 'kode' => 'AL']);
        JenisSampel::create(['nama' => 'Air Sungai', 'kode' => 'AS']);
        JenisSampel::create(['nama' => 'Air Higienis', 'kode' => 'AH']);
        JenisSampel::create(['nama' => 'Kebisingan', 'kode' => 'KB']);
    }
}
