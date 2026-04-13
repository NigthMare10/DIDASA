<?php

namespace App\Modulos\OrdenesTrabajo\Policies;

use App\Models\User;
use App\Modulos\OrdenesTrabajo\Models\OrdenTrabajo;

class OrdenTrabajoPolicy
{
    public function view(User $user, OrdenTrabajo $ordenTrabajo): bool
    {
        return $user->id === $ordenTrabajo->user_id;
    }
}
