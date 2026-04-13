<?php

namespace App\Modulos\Citas\Listeners;

use App\Modulos\Citas\Events\CitaConfirmada;
use App\Modulos\Compartido\Enums\EstadoOrdenTrabajo;
use App\Modulos\OrdenesTrabajo\Models\OrdenTrabajo;

class CrearOrdenTrabajoDesdeCita
{
    public function handle(CitaConfirmada $event): void
    {
        $cita = $event->cita->loadMissing('vehiculo', 'usuario');

        $orden = OrdenTrabajo::firstOrCreate(
            ['cita_id' => $cita->id],
            [
                'user_id' => $cita->user_id,
                'vehiculo_id' => $cita->vehiculo_id,
                'numero_orden' => 'OT-'.now()->format('YmdHis'),
                'titulo' => 'Orden generada desde cita web',
                'descripcion' => $cita->notas,
                'estado' => EstadoOrdenTrabajo::Agendada->value,
                'progreso' => 15,
                'fecha_ingreso' => $cita->fecha,
                'fecha_estimada' => $cita->fecha,
                'total_estimado' => 0,
            ],
        );

        if ($orden->eventos()->doesntExist()) {
            $orden->eventos()->createMany([
                ['titulo' => 'Cita confirmada', 'descripcion' => 'Tu cita fue registrada correctamente.', 'estado_etapa' => 'confirmada', 'orden' => 1, 'completado' => true],
                ['titulo' => 'Recepcion programada', 'descripcion' => 'Tu vehiculo sera recibido en la fecha seleccionada.', 'estado_etapa' => 'recepcion', 'orden' => 2, 'completado' => false],
                ['titulo' => 'Diagnostico inicial', 'descripcion' => 'Se definira el alcance del servicio al ingresar.', 'estado_etapa' => 'diagnostico', 'orden' => 3, 'completado' => false],
                ['titulo' => 'Entrega', 'descripcion' => 'Se notificara cuando el vehiculo este listo.', 'estado_etapa' => 'entrega', 'orden' => 4, 'completado' => false],
            ]);
        }
    }
}
