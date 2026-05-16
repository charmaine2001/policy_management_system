<?php

namespace Database\Factories;

use App\Models\Policy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Policy>
 */
class PolicyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'policy_number' => 'ZIM-POL-' . $this->faker->unique()->numerify('#####'),
            'user_id' => \App\Models\User::factory(),
            'policy_type_id' => \App\Models\PolicyType::factory(),
            'plan_type' => $this->faker->randomElement(['Standard', 'Premium']),
            'final_price' => $this->faker->randomFloat(2, 100, 5000),
            'start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'renewal_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'status' => $this->faker->randomElement(['Active', 'Expired', 'Pending Renewal']),
        ];
    }
}
