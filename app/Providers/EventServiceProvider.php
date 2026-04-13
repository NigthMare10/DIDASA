<?php

namespace App\Providers;

use App\Modulos\Citas\Events\CitaConfirmada;
use App\Modulos\Citas\Listeners\CrearOrdenTrabajoDesdeCita;
use App\Modulos\Citas\Listeners\RegistrarActividadCita;
use App\Modulos\Cotizaciones\Events\CotizacionEnviada;
use App\Modulos\Cotizaciones\Listeners\RegistrarActividadCotizacion;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CitaConfirmada::class => [
            CrearOrdenTrabajoDesdeCita::class,
            RegistrarActividadCita::class,
        ],
        CotizacionEnviada::class => [
            RegistrarActividadCotizacion::class,
        ],
    ];
}
