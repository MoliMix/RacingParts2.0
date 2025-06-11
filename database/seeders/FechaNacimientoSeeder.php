<?php

namespace Database\Seeders;

use App\Models\FechaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FechaNacimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        FechaModel::factory(25)->create();
    }
}
