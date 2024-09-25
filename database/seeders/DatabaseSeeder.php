<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            GolonganSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            PeraturanSeeder::class,
            PengawetanSeeder::class,
            JenisParameterSeeder::class,
            JenisWadahSeeder::class,
            ParameterSeeder::class,
            AcuanMetodeSeeder::class,
            UserParameterSeeder::class,
            TandaTanganSeeder::class,
            JenisSampelSeeder::class,
            KodeRetribusiSeeder::class,
        ]);
    }
}
