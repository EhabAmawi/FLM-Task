<?php

namespace Database\Factories;

use App\Models\PromoCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PromoCode>
 */
class PromoCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->word(),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'discount' => $this->faker->randomFloat(2, 0, 100),
            'discount_type' => $this->faker->randomElement(['percentage', 'fixed']),
            'max_uses' => $this->faker->numberBetween(1, 100),
            'max_uses_per_user' => $this->faker->numberBetween(1, 100),
            'users_ids' => ['*'],
        ];
    }
}
