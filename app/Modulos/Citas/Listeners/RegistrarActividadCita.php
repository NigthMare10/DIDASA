<?php

namespace App\Modulos\Citas\Listeners;

use App\Modulos\Citas\Events\CitaConfirmada;

class RegistrarActividadCita
{
    public function handle(CitaConfirmada $event): void
    {
        activity()
            ->causedBy($event->cita->usuario)
            ->performedOn($event->cita)
            ->event('cita_confirmada')
            ->withProperties([
                'fecha' => $event->cita->fecha?->format('Y-m-d'),
                'hora' => $event->cita->hora,
            ])
            ->log('Cita confirmada desde el portal');
    }
}
