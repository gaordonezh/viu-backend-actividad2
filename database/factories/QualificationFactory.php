<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Qualification>
 */
class QualificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'stars' => fake()->randomElement([1, 2, 3, 4, 5]),
            'comment' => fake()->paragraph(1),
            'journey_id' => 1,
            "user_id" => 1
        ];
    }
}
