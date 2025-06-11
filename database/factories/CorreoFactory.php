<?php

namespace Database\Factories;

use App\Models\CorreoModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CorreoFactory extends Factory
{
    protected $model = CorreoModel::class;
    public function definition(): array
    {
        return [
            'correo' => fake()->unique()->safeEmail(),
        ];
    }
}
