<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        User::insert([
            'name' => 'Roshan Poudel',
            'email' => 'imroshanpoudel@gmail.com',
            'password' => bcrypt('Admin#12345@'),

        ]);
    }
}
