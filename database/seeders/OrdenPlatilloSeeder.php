<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrdenPlatillo;

class OrdenPlatilloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrdenPlatillo::factory(5)->create();
    }
}
