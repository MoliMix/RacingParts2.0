<?php

namespace Database\Seeders;

use App\Models\ApellidoModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApellidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApellidoModel::factory(25)->create();
    }
}
