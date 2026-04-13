<?php

namespace App\Modulos\Compartido\Enums;

enum EstadoOrdenTrabajo: string
{
    case Agendada = 'agendada';
    case Recepcion = 'recepcion';
    case Diagnostico = 'diagnostico';
    case EnProceso = 'en_proceso';
    case Lista = 'lista';
    case Entregada = 'entregada';
}
