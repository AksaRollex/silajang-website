<?php

namespace Database\Seeders;

use App\Models\DetailUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        User::create([
            'id' => 1,
            'nama' => 'Administrator',
            'email' => 'admin@silajang.go.id',
            'password' => bcrypt('12345678'),
            'phone' => '',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 2,
        ])->assignRole('admin');

        User::create([
            'id' => 2,
            'nama' => 'Herlina Hamzah, S.T.',
            'email' => 'herlinas1512ln@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '081230237372',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 2,
        ])->assignRole('kepala-upt');

        User::create([
            'id' => 3,
            'nama' => 'Mutya Sandei Sahasrikirana, S.Si.',
            'email' => 'mutyasandeis@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '085735535633',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 2,
        ])->assignRole('koordinator-teknis');

        User::create([
            'id' => 4,
            'nama' => "Kartika Arifatunnisa', A.Md., K.L.",
            'email' => 'kartikaarifa91@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '081233148205',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 2,
        ])->assignRole('koordinator-administrasi');

        User::create([
            'id' => 5,
            'nama' => "Najihah, S.Si.",
            'email' => 'nnajihah945@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '082257237831',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 2,
        ])->assignRole('analis');

        User::create([
            'id' => 6,
            'nama' => "Eko Januar Anggra, S.Si.",
            'email' => 'experianggra@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '082132676601',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 2,
        ])->assignRole('analis');

        User::create([
            'id' => 7,
            'nama' => "Ayu Nia Maulidiyah, S.Si.",
            'email' => 'ayuniamaulidiyah@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '085748405755',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 2,
        ])->assignRole('analis');

        User::create([
            'id' => 8,
            'nama' => "Wahyu Chandra Eko Utoro, S.Ak.",
            'email' => 'wahyu.chandra222@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '082228569583',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 2,
        ])->assignRole('pengambil-sample');

        User::create([
            'id' => 9,
            'nama' => "M. Renjis Setiawan, S.T.",
            'email' => 'renjiss12@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '089513697116',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 2,
        ])->assignRole('pengambil-sample');

        User::create([
            'id' => 10,
            'nama' => 'Customer Test',
            'email' => 'customer@testing.com',
            'password' => bcrypt('12345678'),
            'phone' => '08123456789',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'confirmed' => true,
            'golongan_id' => 1,
        ])->assignRole('customer');
    }
}
