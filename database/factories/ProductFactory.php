<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// php artisan make:factory ProductFactory
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku'=>$this->faker->unique()->numberBetween(100000, 999999),
            'name'=> $this->faker->sentence(),
            'description'=> $this->faker->text(100),
            'image_path'=>'products/' . $this->faker->image('public/storage/products', 640, 480, null, false),
            'price'=>$this->faker->randomFloat(2, 10, 1000),
            'subcategory_id'=>$this->faker->numberBetween(1, 632),
            'stock'=>$this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
