<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journey>
 */
class JourneyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $initDatetime = fake()->dateTimeBetween('now','+1 years')->format('Y-m-d H:i:s');
        return [
            'origin' => fake()->randomElement(["Lima", "Arequipa", "Callao", "Cusco", "Piura"]),
            'destiny' => fake()->randomElement(["Villa del Salvador", "Chorrillos Centro", "La Molina", "San Miguel", "Tacna"]),
            'datetime_start' => $initDatetime,
            'datetime_end' =>date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($initDatetime))),
            'quotas' =>fake()->numberBetween(1, 4),
            'price' => fake()->numberBetween(500, 10000),
            'status' =>fake()->randomElement(['DISPONIBLE', 'COMPLETO', 'EN CURSO', 'CANCELADO', 'FINALIZADO']),
            'description' => 'Descripcion del viaje ...',
            'vehicle_plate' => Vehicle::inRandomOrder()->first()->plate
        ];
    }
}
