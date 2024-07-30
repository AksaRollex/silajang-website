<?php

namespace Database\Seeders;

use App\Models\JenisParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisParameter::create(['nama' => 'Fisika']);
        JenisParameter::create(['nama' => 'Kimia']);
        JenisParameter::create(['nama' => 'Mikrobiologi']);
    }
}
