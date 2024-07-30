<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

        Setting::create([
            'app' => 'SI-LAJANG',
            'description' =>  'Sistem Informasi Laboratorium Lingkungan Jombang',
            'logo_depan' =>  '/media/logo-depan.png',
            'logo_dalam' =>  '/media/logo-dalam.png',
            'banner' =>  '/media/dlh-jombang.jpg',
            'bg_auth' =>  '/media/misc/auth-bg.png',
            'kop_app' =>  '',
            'kop_sni' =>  '',
            'dinas' =>  'DINAS LINGKUNGAN HIDUP',
            'pemerintah' =>  'PEMERINTAH KABUPATEN JOMBANG',
            'alamat' =>  '',
            'telepon' =>  '',
            'email' =>  '',
        ]);
    }
}
