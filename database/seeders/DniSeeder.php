<?php

namespace Database\Seeders;

use App\Models\DniModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DniModel::factory(25)->create();
    }
}
