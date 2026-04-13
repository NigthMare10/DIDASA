<?php

namespace Tests\Feature\Cotizaciones;

use App\Models\User;
use App\Modulos\Servicios\Models\Servicio;
use App\Modulos\Vehiculos\Models\Vehiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrearCotizacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_una_cotizacion_con_item_manual_y_servicio(): void
    {
        $this->seed();

        $usuario = User::where('email', 'cesar@didasa.test')->firstOrFail();
        $vehiculo = Vehiculo::factory()->create(['user_id' => $usuario->id]);
        $servicio = Servicio::firstOrFail();

        $items = [
            ['tipoItem' => 'servicio', 'servicioId' => $servicio->id, 'cantidad' => 1],
            ['tipoItem' => 'manual', 'descripcion' => 'Revision especial', 'precioUnitario' => 300, 'cantidad' => 1],
        ];

        $response = $this->actingAs($usuario)->post(route('cotizaciones.store'), [
            'vehiculoId' => $vehiculo->id,
            'notas' => 'Necesito revision general.',
            'itemsJson' => json_encode($items),
        ]);

        $response->assertRedirect(route('cotizaciones.historial'));

        $this->assertDatabaseCount('cotizaciones', 1);
        $this->assertDatabaseCount('cotizacion_items', 2);
    }
}
