<?php

namespace Database\Factories;

use App\Models\DniModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DniFactory extends Factory
{
    protected $model = DniModel::class;
    public function definition(): array
    {
        return [
            'Dni'=>$this -> faker->numberBetween(10, 1000)
        ];
    }
}
