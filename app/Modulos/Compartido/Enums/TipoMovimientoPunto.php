<?php

namespace App\Modulos\Compartido\Enums;

enum TipoMovimientoPunto: string
{
    case Ganancia = 'ganancia';
    case Ajuste = 'ajuste';
    case Canje = 'canje';
}
