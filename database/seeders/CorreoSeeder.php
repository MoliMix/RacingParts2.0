<?php

namespace Database\Seeders;

use App\Models\CorreoModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorreoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       CorreoModel::factory(25)->create();
    }
}
