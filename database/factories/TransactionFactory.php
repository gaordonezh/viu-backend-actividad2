<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => fake()->randomNumber(3, true),
            'isDiscount' => fake()->randomElement([0, 1]),
            'date' => fake()->dateTime(),
            'journey_id' => 1,
            "account_id" => 1
        ];
    }
}
