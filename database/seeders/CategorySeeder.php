<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Mobile phones, laptops, gadgets',
                'status' => 'active',
            ],
            [
                'name' => 'Fashion',
                'description' => 'Clothing, shoes, accessories',
                'status' => 'active',
            ],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Furniture, appliances, decor',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}