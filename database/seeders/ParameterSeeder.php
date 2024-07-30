<?php

namespace Database\Seeders;

use App\Models\Parameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'nama' => 'Suhu', 'Metode' => 'SNI 06-6989.23-2005', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [], 'jenis_parameter_id' => 1],
            ['id' => 2, 'nama' => 'TSS', 'Metode' => 'SNI 6989.3:2019', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 1],
            ['id' => 3, 'nama' => 'DHL', 'Metode' => 'SNI 6989.37:2019', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 1],
            ['id' => 4, 'nama' => 'pH', 'Metode' => 'SNI 6989.11:2019', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [], 'jenis_parameter_id' => 2],
            ['id' => 5, 'nama' => 'COD', 'Metode' => 'SNI 6989.2:2019', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1, 2], 'jenis_parameter_id' => 2],
            ['id' => 6, 'nama' => 'BOD', 'Metode' => 'SNI 6989.72:2009', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 2],
            ['id' => 7, 'nama' => 'DO', 'Metode' => 'SNI 06-6989.11-2004', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 2],
            ['id' => 8, 'nama' => 'Cu', 'Metode' => 'SNI 6989.6:2009', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 9, 'nama' => 'Cr', 'Metode' => 'SNI 6989.17:2009', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 10, 'nama' => 'Zn', 'Metode' => 'SNI 6989.7:2009', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 11, 'nama' => 'Klorin Bebas', 'Metode' => 'IKM.KJB.39', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 2], 'jenis_parameter_id' => 3],
            ['id' => 12, 'nama' => 'Amonia Total', 'Metode' => 'SNI 06.6989.30-2005', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [], 'jenis_parameter_id' => 2],
            ['id' => 13, 'nama' => 'Amonia Bebas', 'Metode' => 'IKM.KJB-19 (Kalkulasi)', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1, 2], 'jenis_parameter_id' => 2],
            ['id' => 14, 'nama' => 'Ortho phospat', 'Metode' => 'SNI 06.6989.31-2005', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 2],
            ['id' => 15, 'nama' => 'Total phospat', 'Metode' => 'SNI 06.6989.31-2005', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 2], 'jenis_parameter_id' => 2],
            ['id' => 16, 'nama' => 'Surfaktan anionik', 'Metode' => 'SNI 06-6989.51-2005', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 2],
            ['id' => 17, 'nama' => 'Total Coli (MPN)', 'Metode' => 'SM APHA 23rd. Ed, 9221 B, C, 2017', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 3],
            ['id' => 18, 'nama' => 'Total Coli (CFU)', 'Metode' => 'SM APHA 23rd. Ed, 9222 J, 2017', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1], 'jenis_parameter_id' => 3],
            ['id' => 19, 'nama' => 'E. coli (CFU)', 'Metode' => 'SM APHA 23rd. Ed, 9222 J, 2017', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1], 'jenis_parameter_id' => 3],
            ['id' => 20, 'nama' => 'Minyak dan Lemak', 'Metode' => 'SNI 6989.10:2011', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 2], 'jenis_parameter_id' => 2],
            ['id' => 21, 'nama' => 'Phenol', 'Metode' => 'SNI 06-6989.21-2004', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 2], 'jenis_parameter_id' => 2],
            ['id' => 22, 'nama' => 'Sulfida', 'Metode' => 'SNI 6989.70:2009', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 2, 5], 'jenis_parameter_id' => 2],
            ['id' => 23, 'nama' => 'Nitrit', 'Metode' => 'SM APHA 23rd. Ed, 4500 B, 2017', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1], 'jenis_parameter_id' => 2],
            ['id' => 24, 'nama' => 'Nitrat', 'Metode' => 'SM APHA 23rd. Ed, 4500 B, 2017', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1], 'jenis_parameter_id' => 2],
            ['id' => 25, 'nama' => 'Krom Heksavalen', 'Metode' => 'SNI 6989.71:2009', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 6], 'jenis_parameter_id' => 1],
            ['id' => 26, 'nama' => 'Nitrogen', 'Metode' => 'JIS K0102 butir 45.2-2008', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 2], 'jenis_parameter_id' => 2],
            ['id' => 27, 'nama' => 'Pb', 'Metode' => 'SNI 6989.8:2009', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 28, 'nama' => 'Cd', 'Metode' => 'SNI 6989.16:2009', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 29, 'nama' => 'Fe', 'Metode' => 'SNI 06-6989.21-2004', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 30, 'nama' => 'Mn', 'Metode' => 'SNI 6989.5:2009', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 31, 'nama' => 'As', 'Metode' => 'SNI 6989.81:2018', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 32, 'nama' => 'Fenol', 'Metode' => 'SNI 06-6989-21:2004', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 2], 'jenis_parameter_id' => 2],
            ['id' => 33, 'nama' => 'Warna', 'Metode' => 'SNI 6989.80:2011', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 1],
            ['id' => 34, 'nama' => 'Klorida', 'Metode' => 'SNI 6989.19:2009', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [], 'jenis_parameter_id' => 2],
            ['id' => 35, 'nama' => 'Kekeruhan', 'Metode' => 'SNI 06-6989.25-2005', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 1],
            ['id' => 36, 'nama' => 'Kesadahan Total', 'Metode' => 'SNI 06-6989.12-2004', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 37, 'nama' => 'Kalsium', 'Metode' => 'SNI 06-6989.12-2004', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 38, 'nama' => 'Magnesium', 'Metode' => 'SNI 06-6989.12-2004', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 2],
            ['id' => 39, 'nama' => 'Rasa', 'Metode' => 'IKM-KJB.28 (Organoleptik)', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 1],
            ['id' => 40, 'nama' => 'Bau', 'Metode' => 'IKM-KJB.29 (Organoleptik)', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 1],
            ['id' => 41, 'nama' => 'Surfaktan', 'Metode' => 'SNI 06-6989.51-2005', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 1],
            ['id' => 42, 'nama' => 'KMnO4', 'Metode' => 'SNI 06-6989.22-2004', 'harga' => 0, 'is_akreditasi' => 0, 'pengawetan' => [1, 3], 'jenis_parameter_id' => 1],
            ['id' => 43, 'nama' => 'TDS', 'Metode' => 'SNI 6989.37:2019', 'harga' => 0, 'is_akreditasi' => 1, 'pengawetan' => [1], 'jenis_parameter_id' => 1],
        ];

        foreach ($data as $item) {
            $param = Parameter::create([
                'id' => $item['id'],
                'nama' => $item['nama'],
                'metode' => $item['Metode'],
                'harga' => $item['harga'],
                'is_akreditasi' => $item['is_akreditasi'],
                'jenis_parameter_id' => $item['jenis_parameter_id'],
            ]);

            $param->pengawetans()->sync($item['pengawetan']);
        }
    }
}
