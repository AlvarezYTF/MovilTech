<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            [
                'id'    => 1,
                'name'  => 'Forros de iphone',
                'slug'  => 'forros-de-iphone',
                'created_at' => now()
            ]
        ]);

        $categories->each(function ($category){
            Category::insert($category);
        });
    }
}
