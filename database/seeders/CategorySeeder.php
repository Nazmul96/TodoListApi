<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['category_name' => 'Clinical Care'],
            ['category_name' => 'Health Recordings'],
            ['category_name' => 'Personal Care'],
            ['category_name' => 'Activities & Social'],
            ['category_name' => 'Health Visit'],
            ['category_name' => 'Handover']
        ]);
    }
}
