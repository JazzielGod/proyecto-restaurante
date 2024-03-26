<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orden>
 */
class OrdenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mesa' => $this->faker->unique()->numberBetween(1, 20),
            'tipo_orden' => $this->faker->randomElement(['domicilio', 'restaurante']),
            'direccion' => $this->faker->words(1, true),
            'fecha' => $this->faker->dateTimeBetween('2023-01-01', '2023-12-31')->format('Y-m-d'),
            'id_cliente' => ClienteFactory::new(),
        ];
    }
}
