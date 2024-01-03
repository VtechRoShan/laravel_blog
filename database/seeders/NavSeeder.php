<?php

namespace Database\Seeders;

use App\Models\navigation;
use Illuminate\Database\Seeder;

class NavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'How-to',
            ],
            [
                'name' => 'AWS',
            ],
            [
                'name' => 'Azure',
            ],
            [
                'name' => 'GCP',
            ],
            [
                'name' => 'DevOps',
            ],
        ];
        navigation::insert($data);
    }
}
