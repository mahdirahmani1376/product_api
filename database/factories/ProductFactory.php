<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'default_colors'=>fake()->colorName(),
            'category_id'=> Category::find(rand(1, count(Category::all()))),
            'brand_id'=> Category::find(rand(1, count(Category::all()))),
            'width'=> rand(1, 10),
            'height'=> rand(1, 10),
            'depth'=> rand(1, 10),
            'image_url'=> fake()->imageUrl(),
        ];
    }
}
