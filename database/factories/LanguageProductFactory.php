<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use PHPUnit\Framework\Constraint\Count;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LanguageProduct>
 */
class LanguageProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
//        $ProductId = Product::find(rand(1, count(Category::all())));
//        $LanguageCount = count(Language::all());
//
//        for($i =0; $i <= $LanguageCount; $i++){
        return [
        "language_id"=> Language::find(rand(1, count(Category::all()))),
        "name"=> fake()->text(20),
        "meta_title"=> fake()->text(30),
        "meta_description"=> fake()->sentence(),
        "meta_keywords"=> fake()->text(20),
        "canonical"=> fake()->text(10),
        "description"=> fake()->sentence(10),
        ];
//        }
    }
}
