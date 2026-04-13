<?php

namespace Tests\Feature\Vehiculos;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrarVehiculoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_registrar_un_vehiculo(): void
    {
        $this->seed();

        $usuario = User::where('email', 'cesar@didasa.test')->firstOrFail();

        $response = $this->actingAs($usuario)->post(route('vehiculos.store'), [
            'marca' => 'Toyota',
            'modelo' => 'Hilux',
            'anio' => 2024,
            'placa' => 'AAA-2026',
            'vin' => '1HGBH41JXMN109186',
            'kilometraje' => 1500,
            'color' => 'Blanco',
        ]);

        $response->assertRedirect(route('vehiculos.index'));

        $this->assertDatabaseHas('vehiculos', [
            'user_id' => $usuario->id,
            'placa' => 'AAA-2026',
        ]);
    }
}
