<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlatilloInventario;

class PlatilloInventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlatilloInventario::factory(5)->create();
    }
}
