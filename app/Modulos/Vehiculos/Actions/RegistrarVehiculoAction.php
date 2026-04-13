<?php

namespace App\Modulos\Vehiculos\Actions;

use App\Models\User;
use App\Modulos\Vehiculos\Models\Vehiculo;

class RegistrarVehiculoAction
{
    public function ejecutar(User $usuario, array $datos): Vehiculo
    {
        $vehiculo = $usuario->vehiculos()->create($datos);

        activity()
            ->causedBy($usuario)
            ->performedOn($vehiculo)
            ->event('vehiculo_registrado')
            ->withProperties([
                'placa' => $vehiculo->placa,
                'marca' => $vehiculo->marca,
                'modelo' => $vehiculo->modelo,
            ])
            ->log('Vehiculo registrado desde el portal');

        return $vehiculo;
    }
}
