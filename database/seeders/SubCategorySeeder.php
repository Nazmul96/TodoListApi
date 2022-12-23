<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubCategory::insert([
            [
                'category_id' => 6,
                'subcat_name' => 'Health Professional'
            ],
            [
                'category_id' => 6,
                'subcat_name' => 'Hospital'
            ],

        ]);
    }
}
