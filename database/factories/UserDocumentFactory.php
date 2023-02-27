<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDocument>
 */
class UserDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'filename' => fake()->jobTitle(),
            'url' => fake()->url(),
            'extension' => fake()->randomElement(["pdf", "jpg", "png"]),
            'user_id' => fake()->numberBetween(1, 3),
        ];
    }
}