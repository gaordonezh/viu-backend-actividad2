<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleDocument>
 */
class VehicleDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement(["Foto del vehiculo", "Matricula del vehiculo", "Seguro de accidentes"]),
            'url' => 'public/vehicles/docs/'. fake()->randomElement(["test.png", "car.png", "matricula.doc"]),
            'extension' => fake()->randomElement(["png", "pdf", "doc"]),
            'vehicle_plate' => Vehicle::inRandomOrder()->first()->plate
        ];
    }
}
