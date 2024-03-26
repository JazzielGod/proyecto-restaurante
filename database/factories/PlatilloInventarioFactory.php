<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Platillo;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlatilloInventario>
 */
class PlatilloInventarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_platillo' => PlatilloFactory::new(),
            'id_inventario' => InventarioFactory::new(),
            'cantidad' => $this->faker->randomFloat(2, 1, 10),
        ];
    }
}
