<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\LanguageProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Brand::truncate();
        Category::truncate();
        User::truncate();

        $this->call([
            LanguageSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
        ]);

        Category::factory(10)->create()->each(function($category){
            Product::factory(10)->create([
                'category_id' => $category,
                'brand_id'=> Brand::find(rand(1,count(Brand::all()))),
            ]);
        });


    }
}
