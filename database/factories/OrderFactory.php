<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'total' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
