<?php

namespace Database\Seeders;

use App\Models\Peraturan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeraturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Peraturan::create([
            'nama' => 'Peraturan Menteri Lingkungan Hidup Republik Indonesia',
            'nomor' => 'Nomor 5 tahun 2014',
            'tentang' => 'Baku Mutu Air Limbah'
        ]);
        Peraturan::create([
            'nama' => 'Peraturan Menteri Lingkungan Hidup dan Kehutanan Republik Indonesia',
            'nomor' => 'P.68/Menlhk/Setjen/Kum.1/8/2016',
            'tentang' => 'Baku Mutu Air Limbah Domestik'
        ]);
        Peraturan::create([
            'nama' => 'Peraturan Menteri Lingkungan Hidup dan Kehutanan Republik Indonesia',
            'nomor' => 'P.59/Menlhk/Setjen/Kum.1/7/2016',
            'tentang' => 'Baku Mutu Lindi Bagi Usaha dan/atau Kegiatan Tempat Pemrosesan Akhir Sampah'
        ]);
        Peraturan::create([
            'nama' => 'Peraturan Gubernur Jawa Timur',
            'nomor' => 'Nomor 72 Tahun 2013',
            'tentang' => 'Baku Mutu Air Limbah Bagi Industri dan/atau Kegiatan Usaha Lainnya'
        ]);
        Peraturan::create([
            'nama' => 'Peraturan Gubernur Jawa Timur',
            'nomor' => 'Nomor 52 Tahun 2014',
            'tentang' => 'Perubahan atas Peraturan Gubernur Jawa Timur Nomor 72 tahun 2013 tentang Baku Mutu Air Limbah Bagi Industri dan/atau Kegiatan Usaha Lainnya'
        ]);
        Peraturan::create([
            'nama' => 'Peraturan Menteri Kesehatan Republik Indonesia',
            'nomor' => 'Nomor 2 tahun 2023',
            'tentang' => 'Peraturan Peaksanaan Peraturan Pemerintah Nomor 66 tahun 2014 tentang Kesehatan Lingkungan'
        ]);
    }
}
