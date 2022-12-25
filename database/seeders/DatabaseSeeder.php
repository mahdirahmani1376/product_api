<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\LanguageProduct;
use App\Models\Product;
use Spatie\Permission\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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

        $this->call([
            LanguageSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            TagSeeder::class,
        ]);

        $writer = Role::create(['name'=>'writer']);
        $admin = Role::create(['name'=>'admin']);
        $SuperAdmin = Role::create(['name'=>'Super Admin']);
        $EditProducts = Permission::create(['name'=>'edit products']);
        $EditProducts->syncPermissions([$writer,$admin]);
        $mahdi = User::where('name','mahdi rahmani')->first();
        $mahdi->assignRole(['admin','Super Admin','writer']);

        $Languages = Language::all();

        Category::factory()->create(['name'=>'test']);

        Category::factory(10)->create()->each(function($category) use ($Languages){
            Product::factory(10)->create([
                'category_id' => $category,
                'brand_id'=> Brand::find(rand(1,count(Brand::all()))),
                'user_id' => Brand::find(rand(1,count(User::all()))),
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
