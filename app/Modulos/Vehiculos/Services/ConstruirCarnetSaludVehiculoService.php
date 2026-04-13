<?php

namespace App\Modulos\Vehiculos\Services;

use App\Modulos\Vehiculos\Models\Vehiculo;

class ConstruirCarnetSaludVehiculoService
{
    public function ejecutar(Vehiculo $vehiculo): array
    {
        $vehiculo->loadMissing([
            'cotizaciones.items',
            'citas.ordenTrabajo',
            'ordenesTrabajo.eventos',
        ]);

        $historialServicios = $vehiculo->ordenesTrabajo
            ->sortByDesc('fecha_ingreso')
            ->map(fn ($orden) => [
                'titulo' => $orden->titulo,
                'estado' => $orden->estado,
                'fecha' => optional($orden->fecha_ingreso)->format('d/m/Y'),
                'descripcion' => $orden->descripcion ?: 'Seguimiento generado desde el portal.',
            ])
            ->values();

        $recordatorios = collect([
            $vehiculo->kilometraje >= 5000 ? 'Programar cambio de aceite preventivo.' : null,
            $vehiculo->kilometraje >= 10000 ? 'Revisar alineacion y balanceo.' : null,
            $vehiculo->citas->where('fecha', '>=', now()->toDateString())->sortBy('fecha')->first()
                ? 'Tienes una cita proxima registrada en el portal.'
                : 'Sin recordatorios pendientes por ahora.',
        ])->filter()->unique()->values();

        $proximaRevision = $vehiculo->kilometraje < 5000 ? 'A los 5,000 km' : ($vehiculo->kilometraje < 10000 ? 'A los 10,000 km' : 'Revision recomendada inmediata');

        return [
            'estadoGeneral' => $historialServicios->isEmpty() ? 'Sin historial tecnico aun' : 'Historial digital actualizado',
            'proximaRevision' => $proximaRevision,
            'historialServicios' => $historialServicios,
            'recordatorios' => $recordatorios,
            'cotizacionesRelacionadas' => $vehiculo->cotizaciones->sortByDesc('created_at')->values(),
            'ultimaOrden' => $vehiculo->ordenesTrabajo->sortByDesc('created_at')->first(),
        ];
    }
}
