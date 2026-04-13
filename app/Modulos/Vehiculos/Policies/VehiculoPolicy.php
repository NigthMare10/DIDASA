<?php

namespace App\Modulos\Vehiculos\Policies;

use App\Models\User;
use App\Modulos\Vehiculos\Models\Vehiculo;

class VehiculoPolicy
{
    public function view(User $user, Vehiculo $vehiculo): bool
    {
        return $user->id === $vehiculo->user_id;
    }

    public function delete(User $user, Vehiculo $vehiculo): bool
    {
        return $user->id === $vehiculo->user_id;
    }
}
