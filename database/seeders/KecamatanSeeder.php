<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kecamatans')->delete();

        $data = [
            ['1', 'Perak'],
            ['2', 'Gudo'],
            ['3', 'Ngoro'],
            ['4', 'Bareng'],
            ['5', 'Wonosalam'],
            ['6', 'Mojoagung'],
            ['7', 'Mojowarno'],
            ['8', 'Diwek'],
            ['9', 'Jombang'],
            ['10', 'Peterongan'],
            ['11', 'Sumobito'],
            ['12', 'Kesamben'],
            ['13', 'Tembelang'],
            ['14', 'Ploso'],
            ['15', 'Plandaan'],
            ['16', 'Kabuh'],
            ['17', 'Kudu'],
            ['18', 'Bandarkedungmulyo'],
            ['19', 'Jogoroto'],
            ['20', 'Megaluh'],
            ['21', 'Ngusikan'],
        ];

        foreach ($data as $item) {
            Kecamatan::create([
                'id' => $item[0],
                'nama' => $item[1],
            ]);
        }
    }
}
