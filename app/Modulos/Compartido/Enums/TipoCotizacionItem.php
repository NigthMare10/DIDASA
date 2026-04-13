<?php

namespace App\Modulos\Compartido\Enums;

enum TipoCotizacionItem: string
{
    case Servicio = 'servicio';
    case Paquete = 'paquete';
    case Manual = 'manual';
}
