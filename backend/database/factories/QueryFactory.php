<?php

namespace Database\Factories;

use App\Models\Query;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Query>
 */
class QueryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => \App\Models\User::factory(),
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'response' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement(['Open', 'Resolved', 'In Progress']),
        ];
    }
}
