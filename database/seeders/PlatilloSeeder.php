<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platillo;

class PlatilloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Platillo::factory(5)->create();
    }
}
