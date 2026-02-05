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
            ['name' => 'Art', 'slug' => 'art'],
            ['name' => 'Music', 'slug' => 'music'],
            ['name' => 'Fashion', 'slug' => 'fashion'],
            ['name' => 'Finance', 'slug' => 'finance'],
            ['name' => 'Marketing', 'slug' => 'marketing'],
            ['name' => 'Design', 'slug' => 'design'],
            ['name' => 'Photography', 'slug' => 'photography'],
            ['name' => 'Writing', 'slug' => 'writing'],
            ['name' => 'History', 'slug' => 'history'],
            ['name' => 'Culture', 'slug' => 'culture'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']], // Find by slug
                ['name' => $category['name']]   // Update or create with this data
            );
        }
    }
}