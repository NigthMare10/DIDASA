<?php

namespace Database\Factories;

use App\Models\User;
use App\Modulos\Vehiculos\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Vehiculo> */
class VehiculoFactory extends Factory
{
    protected $model = Vehiculo::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'marca' => fake()->randomElement(['Toyota', 'Honda', 'Ford']),
            'modelo' => fake()->randomElement(['Hilux', 'Civic', 'Ranger']),
            'anio' => fake()->numberBetween(2018, 2025),
            'placa' => strtoupper(fake()->bothify('???-####')),
            'vin' => strtoupper(fake()->bothify('#################')),
            'kilometraje' => fake()->numberBetween(0, 120000),
            'color' => fake()->randomElement(['Blanco', 'Gris', 'Negro']),
        ];
    }
}
