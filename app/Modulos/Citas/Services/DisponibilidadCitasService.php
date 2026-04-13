<?php

namespace App\Modulos\Citas\Services;

use App\Modulos\Citas\Models\Cita;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class DisponibilidadCitasService
{
    public function obtenerMes(string $referencia = null): CarbonImmutable
    {
        if ($referencia !== null) {
            return CarbonImmutable::parse($referencia)->startOfMonth();
        }

        return CarbonImmutable::now()->startOfMonth();
    }

    public function construirCalendario(CarbonImmutable $mes): array
    {
        $inicio = $mes->startOfMonth()->startOfWeek();
        $fin = $mes->endOfMonth()->endOfWeek();
        $cursor = $inicio;
        $semanas = [];

        while ($cursor->lte($fin)) {
            $semana = [];

            for ($indice = 0; $indice < 7; $indice++) {
                $semana[] = [
                    'fecha' => $cursor,
                    'esDelMesActual' => $cursor->month === $mes->month,
                    'esDiaLaboral' => in_array($cursor->dayOfWeekIso, config('didasa.horarios.diasLaborales'), true),
                    'esPasado' => $cursor->lt(today()),
                ];

                $cursor = $cursor->addDay();
            }

            $semanas[] = $semana;
        }

        return $semanas;
    }

    public function obtenerHorasDisponibles(?string $fechaSeleccionada): Collection
    {
        if ($fechaSeleccionada === null) {
            return collect();
        }

        $ocupadas = Cita::query()
            ->whereDate('fecha', $fechaSeleccionada)
            ->pluck('hora');

        return collect(config('didasa.horarios.horas'))
            ->filter(fn (string $hora) => ! $ocupadas->contains($hora))
            ->values();
    }

    public function construirRespuestaDisponibilidad(CarbonImmutable $mes): array
    {
        $semanas = collect($this->construirCalendario($mes))
            ->map(fn (array $semana) => collect($semana)
                ->map(fn (array $dia) => [
                    'fecha' => $dia['fecha']->format('Y-m-d'),
                    'dia' => $dia['fecha']->day,
                    'esDelMesActual' => $dia['esDelMesActual'],
                    'esDiaLaboral' => $dia['esDiaLaboral'],
                    'esPasado' => $dia['esPasado'],
                ])->all())
            ->all();

        $horasPorFecha = [];
        $cursor = $mes->startOfMonth();
        $fin = $mes->endOfMonth();

        while ($cursor->lte($fin)) {
            $fecha = $cursor->format('Y-m-d');
            $horasPorFecha[$fecha] = $this->fechaEsValida($fecha)
                ? $this->obtenerHorasDisponibles($fecha)->values()->all()
                : [];
            $cursor = $cursor->addDay();
        }

        return [
            'mes' => $mes->format('Y-m-d'),
            'tituloMes' => $mes->translatedFormat('F Y'),
            'mesAnterior' => $mes->subMonth()->format('Y-m-d'),
            'mesSiguiente' => $mes->addMonth()->format('Y-m-d'),
            'semanas' => $semanas,
            'horasPorFecha' => $horasPorFecha,
        ];
    }

    public function fechaEsValida(string $fecha): bool
    {
        $fechaCarbon = CarbonImmutable::parse($fecha);

        return $fechaCarbon->gte(today())
            && in_array($fechaCarbon->dayOfWeekIso, config('didasa.horarios.diasLaborales'), true);
    }
}
