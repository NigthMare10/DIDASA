<?php

namespace App\Modulos\Citas\Events;

use App\Modulos\Citas\Models\Cita;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CitaConfirmada
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly Cita $cita)
    {
    }
}
