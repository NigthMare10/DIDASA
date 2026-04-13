<?php

namespace App\Modulos\Fidelidad\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modulos\Fidelidad\Models\Insignia;
use App\Modulos\Fidelidad\Services\ResumenFidelidadService;
use Illuminate\Contracts\View\View;

class FidelidadController extends Controller
{
    public function __construct(private readonly ResumenFidelidadService $resumenFidelidadService)
    {
    }

    public function __invoke(): View
    {
        return view('fidelidad.index', [
            ...$this->resumenFidelidadService->construir(auth()->user()),
            'catalogoInsignias' => Insignia::query()->orderBy('orden')->get(),
            'gananciasPuntos' => config('didasa.gananciasPuntos'),
        ]);
    }
}
