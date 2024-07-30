<?php

namespace Database\Seeders;

use App\Models\KabKota;
use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabKotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kab_kotas')->delete();

        $data = [
            ['1', 'KABUPATEN PACITAN'],
            ['2', 'KABUPATEN PONOROGO'],
            ['3', 'KABUPATEN TRENGGALEK'],
            ['4', 'KABUPATEN TULUNGAGUNG'],
            ['5', 'KABUPATEN BLITAR'],
            ['6', 'KABUPATEN KEDIRI'],
            ['7', 'KABUPATEN MALANG'],
            ['8', 'KABUPATEN LUMAJANG'],
            ['9', 'KABUPATEN JEMBER'],
            ['10', 'KABUPATEN BANYUWANGI'],
            ['11', 'KABUPATEN BONDOWOSO'],
            ['12', 'KABUPATEN SITUBONDO'],
            ['13', 'KABUPATEN PROBOLINGGO'],
            ['14', 'KABUPATEN PASURUAN'],
            ['15', 'KABUPATEN SIDOARJO'],
            ['16', 'KABUPATEN MOJOKERTO'],
            ['17', 'KABUPATEN JOMBANG'],
            ['18', 'KABUPATEN NGANJUK'],
            ['19', 'KABUPATEN MADIUN'],
            ['20', 'KABUPATEN MAGETAN'],
            ['21', 'KABUPATEN NGAWI'],
            ['22', 'KABUPATEN BOJONEGORO'],
            ['23', 'KABUPATEN TUBAN'],
            ['24', 'KABUPATEN LAMONGAN'],
            ['25', 'KABUPATEN GRESIK'],
            ['26', 'KABUPATEN BANGKALAN'],
            ['27', 'KABUPATEN SAMPANG'],
            ['28', 'KABUPATEN PAMEKASAN'],
            ['29', 'KABUPATEN SUMENEP'],
            ['71', 'KOTA KEDIRI'],
            ['30', 'KOTA BLITAR'],
            ['31', 'KOTA MALANG'],
            ['32', 'KOTA PROBOLINGGO'],
            ['33', 'KOTA PASURUAN'],
            ['34', 'KOTA MOJOKERTO'],
            ['35', 'KOTA MADIUN'],
            ['36', 'KOTA SURABAYA'],
            ['37', 'KOTA BATU'],
        ];

        foreach ($data as $item) {
            KabKota::create([
                'id' => $item[0],
                'nama' => $item[1],
            ]);
        }

        DB::table('kecamatans')->update(['kab_kota_id' => 17]);
        DB::table('kelurahans')->update(['kab_kota_id' => 17]);
        DB::table('detail_users')->update(['kab_kota_id' => 17]);
    }
}
