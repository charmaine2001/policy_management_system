<?php

namespace Database\Factories;

use App\Models\PolicyType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PolicyType>
 */
class PolicyTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word() . ' Insurance',
            'description' => $this->faker->sentence(),
            'standard_price' => $this->faker->randomFloat(2, 50, 200),
            'premium_price' => $this->faker->randomFloat(2, 201, 500),
            'default_terms' => $this->faker->paragraph(),
        ];
    }
}
