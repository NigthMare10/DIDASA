<?php

namespace App\Modulos\Cotizaciones\Events;

use App\Modulos\Cotizaciones\Models\Cotizacion;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CotizacionEnviada
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly Cotizacion $cotizacion)
    {
    }
}
