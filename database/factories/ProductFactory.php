<?php

namespace Database\Factories;

use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => ucwords($this->faker->words(3, true)),
            'price' => $this->faker->randomFloat(2, 5, 300),
            'manufacturer_id' => Manufacturer::factory(),
            'sku' => strtoupper($this->faker->bothify('??-####')),
        ];
    }
}
