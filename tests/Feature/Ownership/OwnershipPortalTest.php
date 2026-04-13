<?php

namespace Tests\Feature\Ownership;

use App\Models\User;
use App\Modulos\Citas\Models\Cita;
use App\Modulos\Cotizaciones\Models\Cotizacion;
use App\Modulos\OrdenesTrabajo\Models\OrdenTrabajo;
use App\Modulos\Vehiculos\Models\Vehiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnershipPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_puede_ver_el_carnet_de_otro_usuario(): void
    {
        $usuario = User::factory()->create();
        $otroUsuario = User::factory()->create();
        $vehiculo = Vehiculo::factory()->create(['user_id' => $otroUsuario->id]);

        $this->actingAs($usuario)
            ->get(route('vehiculos.carnet', $vehiculo))
            ->assertForbidden();
    }

    public function test_no_puede_eliminar_vehiculo_ajeno(): void
    {
        $usuario = User::factory()->create();
        $otroUsuario = User::factory()->create();
        $vehiculo = Vehiculo::factory()->create(['user_id' => $otroUsuario->id]);

        $this->actingAs($usuario)
            ->delete(route('vehiculos.destroy', $vehiculo))
            ->assertForbidden();
    }

    public function test_no_puede_actualizar_estado_de_cotizacion_ajena(): void
    {
        $usuario = User::factory()->create();
        $otroUsuario = User::factory()->create();
        $vehiculo = Vehiculo::factory()->create(['user_id' => $otroUsuario->id]);
        $cotizacion = Cotizacion::create([
            'user_id' => $otroUsuario->id,
            'vehiculo_id' => $vehiculo->id,
            'numero_cotizacion' => 'COT-OWN-0001',
            'estado' => 'enviada',
            'subtotal' => 100,
            'impuesto' => 15,
            'total' => 115,
            'notas' => null,
            'enviada_en' => now(),
        ]);

        $this->actingAs($usuario)
            ->patch(route('cotizaciones.estado', $cotizacion), ['estado' => 'aprobada'])
            ->assertForbidden();
    }

    public function test_historiales_del_portal_solo_muestran_recursos_propios(): void
    {
        $usuario = User::factory()->create(['name' => 'Cliente Propio']);
        $otroUsuario = User::factory()->create(['name' => 'Cliente Ajeno']);

        $vehiculoPropio = Vehiculo::factory()->create(['user_id' => $usuario->id, 'placa' => 'OWN-1001']);
        $vehiculoAjeno = Vehiculo::factory()->create(['user_id' => $otroUsuario->id, 'placa' => 'OWN-2002']);

        Cotizacion::create([
            'user_id' => $usuario->id,
            'vehiculo_id' => $vehiculoPropio->id,
            'numero_cotizacion' => 'COT-PROPIA',
            'estado' => 'enviada',
            'subtotal' => 100,
            'impuesto' => 15,
            'total' => 115,
            'notas' => null,
            'enviada_en' => now(),
        ]);

        Cotizacion::create([
            'user_id' => $otroUsuario->id,
            'vehiculo_id' => $vehiculoAjeno->id,
            'numero_cotizacion' => 'COT-AJENA',
            'estado' => 'enviada',
            'subtotal' => 200,
            'impuesto' => 30,
            'total' => 230,
            'notas' => null,
            'enviada_en' => now(),
        ]);

        Cita::create([
            'user_id' => $usuario->id,
            'vehiculo_id' => $vehiculoPropio->id,
            'fecha' => now()->addDay()->format('Y-m-d'),
            'hora' => '08:00',
            'estado' => 'confirmada',
            'notas' => 'Cita propia',
        ]);

        Cita::create([
            'user_id' => $otroUsuario->id,
            'vehiculo_id' => $vehiculoAjeno->id,
            'fecha' => now()->addDays(2)->format('Y-m-d'),
            'hora' => '09:00',
            'estado' => 'confirmada',
            'notas' => 'Cita ajena',
        ]);

        OrdenTrabajo::create([
            'user_id' => $usuario->id,
            'vehiculo_id' => $vehiculoPropio->id,
            'cita_id' => null,
            'numero_orden' => 'OT-PROPIA',
            'titulo' => 'Orden propia',
            'descripcion' => 'Orden visible al usuario correcto',
            'estado' => 'agendada',
            'progreso' => 20,
            'fecha_ingreso' => now()->format('Y-m-d'),
            'fecha_estimada' => now()->addDay()->format('Y-m-d'),
            'fecha_entrega' => null,
            'total_estimado' => 0,
        ]);

        OrdenTrabajo::create([
            'user_id' => $otroUsuario->id,
            'vehiculo_id' => $vehiculoAjeno->id,
            'cita_id' => null,
            'numero_orden' => 'OT-AJENA',
            'titulo' => 'Orden ajena',
            'descripcion' => 'No debe verse',
            'estado' => 'agendada',
            'progreso' => 20,
            'fecha_ingreso' => now()->format('Y-m-d'),
            'fecha_estimada' => now()->addDay()->format('Y-m-d'),
            'fecha_entrega' => null,
            'total_estimado' => 0,
        ]);

        $this->actingAs($usuario)
            ->get(route('cotizaciones.historial'))
            ->assertSee('COT-PROPIA')
            ->assertDontSee('COT-AJENA');

        $this->actingAs($usuario)
            ->get(route('citas.historial'))
            ->assertSee('OWN-1001')
            ->assertDontSee('OWN-2002');

        $this->actingAs($usuario)
            ->get(route('ordenes.index'))
            ->assertSee('OT-PROPIA')
            ->assertDontSee('OT-AJENA');
    }
}
