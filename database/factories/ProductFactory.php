<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => Str::limit($this->faker->unique()->sentence(3), 100, ''),
            'price' => $this->faker->numberBetween(500, 20000),
            'amount_available' => $this->faker->numberBetween(1, 100),
        ];
    }
}
