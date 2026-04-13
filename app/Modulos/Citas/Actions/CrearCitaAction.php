<?php

namespace App\Modulos\Citas\Actions;

use App\Models\User;
use App\Modulos\Citas\Events\CitaConfirmada;
use App\Modulos\Citas\Models\Cita;
use App\Modulos\Compartido\Enums\EstadoCita;
use Illuminate\Support\Facades\DB;

class CrearCitaAction
{
    public function ejecutar(User $usuario, array $datos): Cita
    {
        return DB::transaction(function () use ($usuario, $datos): Cita {
            $cita = Cita::create([
                'user_id' => $usuario->id,
                'vehiculo_id' => $datos['vehiculoId'],
                'fecha' => $datos['fecha'],
                'hora' => $datos['hora'],
                'estado' => EstadoCita::Confirmada->value,
                'notas' => $datos['notas'] ?? null,
            ]);

            event(new CitaConfirmada($cita));

            return $cita;
        });
    }
}
