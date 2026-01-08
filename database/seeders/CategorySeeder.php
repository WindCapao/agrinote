<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle'],
            ['name' => 'Travel', 'slug' => 'travel'],
            ['name' => 'Food', 'slug' => 'food'],
            ['name' => 'Health', 'slug' => 'health'],
            ['name' => 'Business', 'slug' => 'business'],
            ['name' => 'Education', 'slug' => 'education'],
            ['name' => 'Entertainment', 'slug' => 'entertainment'],
            ['name' => 'Sports', 'slug' => 'sports'],
            ['name' => 'Science', 'slug' => 'science'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}