<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
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
        // \App\Models\User::factory(10)->create();
        User::factory()->create();
        Brand::factory(10)->create()->unique();
        Brand::create([
            'name' => 'top',
        ]);
        $this->call([
            LanguageSeeder::class,
        ]);
         User::factory()->create([
             'name' => 'mahdi rahmani',
             'email' => 'rahmanimahdi16@gmail.com',
             'password' => bcrypt('Ma13R18@'),
         ]);
    }
}
