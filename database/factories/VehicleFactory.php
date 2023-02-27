<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\Fakecar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->faker->addProvider(new Fakecar($this->faker));
        $vehicle = $this->faker->vehicleArray();

        return [
            'plate' => $this->faker->vehicleRegistration,
            'type' => fake()->randomElement(["CARRO", "MOTO", "BUS", "MICROBUS"]),
            'brand' => strtoupper($vehicle['brand']),
            'reference' => strtoupper($vehicle['model']),
            'model' => (string)$this->faker->biasedNumberBetween(1990, date('Y'), 'sqrt'),
            'color' => fake()->randomElement(["NEGRO", "ROJO", "AZUL", "BLANCO", "VERDE","MORADO"]),
            'ability' =>  $this->faker->vehicleSeatCount,
            'user_id' => fake()->numberBetween(1, 3),
        ];
    }
}
