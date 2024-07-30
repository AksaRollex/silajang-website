<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserParameter::truncate();

        User::find(3)->parameters()->sync([27, 28]);
        User::find(5)->parameters()->sync([5, 12, 13, 35, 42, 9, 31]);
        User::find(6)->parameters()->sync([23, 24, 20, 17, 18, 19, 26, 29]);
        User::find(7)->parameters()->sync([6, 7, 15, 21, 30]);
        User::find(8)->parameters()->sync([4, 35, 11, 10, 3]);
        User::find(9)->parameters()->sync([2, 34, 24, 37, 38, 43]);
    }
}
