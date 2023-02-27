<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ndoc' => fake()->regexify('[A-Z]{3}[0-9]{7}'),
            'tdoc' => fake()->randomElement(["DNI", "CARNET EXT", "RUC", "PASAPORTE"]),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->numerify('+##########'),
            'email' => fake()->email(),
            'password' => Hash::make(fake()->password()),
            'is_active' => fake()->numberBetween(0, 1),
            'address_id' => fake()->numberBetween(1, 3),
            'role_id' => fake()->numberBetween(1, 3),
        ];
    }
}