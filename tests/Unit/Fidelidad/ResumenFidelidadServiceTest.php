<?php

namespace Tests\Unit\Fidelidad;

use App\Models\User;
use App\Modulos\Fidelidad\Models\MovimientoPunto;
use App\Modulos\Fidelidad\Services\ResumenFidelidadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResumenFidelidadServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_calcula_el_nivel_actual_segun_los_puntos(): void
    {
        $this->seed();

        $usuario = User::factory()->create();

        MovimientoPunto::create([
            'user_id' => $usuario->id,
            'tipo' => 'ganancia',
            'descripcion' => 'Prueba de puntos',
            'puntos' => 650,
            'saldo_resultante' => 650,
        ]);

        $resumen = app(ResumenFidelidadService::class)->construir($usuario->fresh());

        $this->assertSame('Plata', $resumen['nivelActual']->nombre);
        $this->assertSame(650, $resumen['puntos']);
    }
}
