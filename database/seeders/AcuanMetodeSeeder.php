<?php

namespace Database\Seeders;

use App\Models\AcuanMetode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcuanMetodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcuanMetode::create(['nama' => 'Sesaat (Grab Sample)']);
    }
}
