<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'How to',
                'slug' => 'how-to',
                'created_at' => now(),
            ],
            [
                'name' => 'AWS Update',
                'slug' => 'aws-update',
                'created_at' => now(),
            ],
            [
                'name' => 'DevsecOps',
                'slug' => 'devsecops',
                'created_at' => now(),
            ],
            [
                'name' => 'Data',
                'slug' => 'data',
                'created_at' => now(),
            ],
            [
                'name' => 'Security & Compliance',
                'slug' => 'security-and-compliance',
                'created_at' => now(),
            ],
            [
                'name' => 'Kubernetes',
                'slug' => 'kubernetes',
                'created_at' => now(),
            ],
            [
                'name' => 'Serverless',
                'slug' => 'serverless',
                'created_at' => now(),
            ],
        ];
        Category::insert($data);
    }
}
