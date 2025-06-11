<?php

namespace Database\Factories;

use App\Models\NombreModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ApellidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = NombreModel::class;

    public function definition(): array
    {
        return [
            'Apellido'=>$this -> faker->lastname
        ];
    }
}
