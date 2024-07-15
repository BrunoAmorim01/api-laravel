<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductMovimentationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'product_id' => Product::factory()->create()->id,
            'quantity' => $this->faker->randomNumber(2),
            'type' => $this->faker->randomElement(['in', 'out']),
            'reason' => $this->faker->randomElement(['sell', 'buy', 'adjustment', 'transfer']),
            'proof' => $this->faker->url(),
        ];
    }
}
