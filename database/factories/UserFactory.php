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
            "first_name" => "Viu user name",
            "last_name" => "Viur user last name",
            "dni" => "12345678L",
            "email" => "seguridadweb@campusviu.es",
            'password' => Hash::make("S3gur1d4d?W3b"),
            "phone" => "+51987654321",
            "country" => "PERU",
            "iban" => "ES9121000418450200051332",
            "about" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse quidem reiciendis voluptas consectetur.",
        ];
    }
}
