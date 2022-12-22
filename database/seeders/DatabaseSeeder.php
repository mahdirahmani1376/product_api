<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\LanguageProduct;
use App\Models\Product;
use App\Models\Role;
use App\Models\Tag;
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
        Tag::truncate();

        Role::create(['name'=>'writer']);
        Role::create(['name'=>'admin']);

        $this->call([
            LanguageSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            TagSeeder::class,
        ]);

        $Languages = Language::all();
        Category::factory(10)->create()->each(function($category) use ($Languages){
            Product::factory(10)->create([
                'category_id' => $category,
                'brand_id'=> Brand::find(rand(1,count(Brand::all()))),
            ])->each(function ($product) use ($Languages){
                $TagId = rand(1,count(Tag::all()));
                $product->tags()->sync($TagId);

                foreach($Languages as $Language){
                    LanguageProduct::factory()->create([
                        'product_id'=> $product->id,
                        'language_id'=> $Language->id,
                    ]);
                }
            })
            ;
        });


    }
}
