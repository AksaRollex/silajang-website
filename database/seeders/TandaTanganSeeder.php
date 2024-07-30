<?php

namespace Database\Seeders;

use App\Models\TandaTangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TandaTanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tanda_tangans')->truncate();

        TandaTangan::create([
            'bagian' => 'Kendali Mutu',
            'user_id' => 2
        ]);

        TandaTangan::create([
            'bagian' => 'Lembar Hasil Uji',
            'user_id' => 2
        ]);

        TandaTangan::create([
            'bagian' => 'SPP',
            'user_id' => 3
        ]);

        TandaTangan::create([
            'bagian' => 'RDPS',
            'user_id' => 3
        ]);

        TandaTangan::create([
            'bagian' => 'SKRD',
            'user_id' => 4
        ]);

        TandaTangan::create([
            'bagian' => 'Pengambilan Sampel (Koordinator Administrasi)',
            'user_id' => 4
        ]);

        TandaTangan::create([
            'bagian' => 'Pengambilan Sampel (Koordinator Teknis)',
            'user_id' => 3
        ]);
    }
}
