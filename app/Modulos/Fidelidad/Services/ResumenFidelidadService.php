<?php

namespace App\Modulos\Fidelidad\Services;

use App\Models\User;
use App\Modulos\Fidelidad\Models\NivelFidelidad;

class ResumenFidelidadService
{
    public function construir(User $usuario): array
    {
        $niveles = NivelFidelidad::query()->orderBy('orden')->get();
        $puntos = (int) $usuario->movimientosPuntos()->sum('puntos');
        $nivelActual = $niveles->where('puntos_minimos', '<=', $puntos)->sortByDesc('puntos_minimos')->first() ?? $niveles->first();
        $siguienteNivel = $niveles->where('puntos_minimos', '>', $puntos)->sortBy('puntos_minimos')->first();

        return [
            'puntos' => $puntos,
            'nivelActual' => $nivelActual,
            'siguienteNivel' => $siguienteNivel,
            'niveles' => $niveles,
            'insignias' => $usuario->load('insignias.insignia')->insignias,
            'historial' => $usuario->movimientosPuntos()->latest()->get(),
        ];
    }
}
