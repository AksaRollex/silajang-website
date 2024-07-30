<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'id' => 1,
            'name' => 'admin',
            'guard_name' => 'api',
            'full_name' => 'Administrator',
        ]);

        Role::create([
            'id' => 2,
            'name' => 'kepala-upt',
            'guard_name' => 'api',
            'full_name' => 'Kepala UPT. Laboratorium Lingkungan',
        ]);

        Role::create([
            'id' => 3,
            'name' => 'koordinator-teknis',
            'guard_name' => 'api',
            'full_name' => 'Koordinator Teknis',
        ]);

        Role::create([
            'id' => 4,
            'name' => 'koordinator-administrasi',
            'guard_name' => 'api',
            'full_name' => 'Koordinator Administrasi',
        ]);

        Role::create([
            'id' => 5,
            'name' => 'analis',
            'guard_name' => 'api',
            'full_name' => 'Analis',
        ]);

        Role::create([
            'id' => 6,
            'name' => 'pengambil-sample',
            'guard_name' => 'api',
            'full_name' => 'Petugas Pengambil Sample',
        ]);

        Role::create([
            'id' => 7,
            'name' => 'customer',
            'guard_name' => 'api',
            'full_name' => 'Customer',
        ]);
    }
}
