<?php

namespace App\Modulos\Cotizaciones\Listeners;

use App\Modulos\Cotizaciones\Events\CotizacionEnviada;

class RegistrarActividadCotizacion
{
    public function handle(CotizacionEnviada $event): void
    {
        activity()
            ->causedBy($event->cotizacion->usuario)
            ->performedOn($event->cotizacion)
            ->event('cotizacion_enviada')
            ->withProperties([
                'numero' => $event->cotizacion->numero_cotizacion,
                'total' => $event->cotizacion->total,
            ])
            ->log('Cotizacion enviada desde el portal');
    }
}
