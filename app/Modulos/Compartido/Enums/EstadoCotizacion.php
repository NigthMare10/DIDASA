<?php

namespace App\Modulos\Compartido\Enums;

enum EstadoCotizacion: string
{
    case Borrador = 'borrador';
    case Enviada = 'enviada';
    case Aprobada = 'aprobada';
    case Rechazada = 'rechazada';
}
