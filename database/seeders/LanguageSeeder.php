<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'iso_code'=>'fa',
            'name'=>'fa',
        ]);
        Language::create(['iso_code'=>'en',
            'name'=>'fa']);
        Language::create(
            ['iso_code'=>'ch',
            'name'=>'fa']
        );
        Language::create(
            ['iso_code'=>'tr',
            'name'=>'fa']
        );
        Language::create(
            ['iso_code'=>'ar',
            'name'=>'fa']
        );
    }
}
