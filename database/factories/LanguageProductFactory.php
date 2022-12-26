<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
        $name = fake()->text(20);
        return [
        "language_id"=> Language::find(rand(1, count(Category::all()))),
        "name"=> $name,
        "slug"=> Str::slug($name),
        "meta_title"=> fake()->text(30),
        "meta_description"=> fake()->sentence(),
        "meta_keywords"=> fake()->text(20),
        "canonical"=> fake()->text(10),
        "description"=> fake()->sentence(10),
        ];
    }
}
