<?php

namespace Tests\Feature\Citas;

use App\Models\User;
use App\Modulos\Vehiculos\Models\Vehiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrearCitaTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirmar_cita_genera_orden_de_trabajo(): void
    {
        $this->seed();

        $usuario = User::where('email', 'cesar@didasa.test')->firstOrFail();
        $vehiculo = Vehiculo::factory()->create(['user_id' => $usuario->id]);

        $response = $this->actingAs($usuario)->post(route('citas.store'), [
            'vehiculoId' => $vehiculo->id,
            'fecha' => now()->addDay()->next('Monday')->format('Y-m-d'),
            'hora' => '08:30',
            'notas' => 'Revision de frenos',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseCount('citas', 1);
        $this->assertDatabaseCount('ordenes_trabajo', 1);
    }
}
