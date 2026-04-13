<?php

namespace App\Modulos\Citas\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modulos\Citas\Actions\CrearCitaAction;
use App\Modulos\Citas\Http\Requests\CrearCitaRequest;
use App\Modulos\Citas\Services\DisponibilidadCitasService;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function __construct(
        private readonly DisponibilidadCitasService $disponibilidadCitasService,
        private readonly CrearCitaAction $crearCitaAction,
    ) {
    }

    public function index(Request $request): View
    {
        $mes = $this->disponibilidadCitasService->obtenerMes($request->string('mes')->toString() ?: null);
        $fechaSeleccionada = $request->string('fecha')->toString() ?: now()->addDay()->format('Y-m-d');

        return view('citas.index', [
            'vehiculos' => $request->user()->vehiculos()->orderBy('marca')->get(),
            'mesInicial' => $mes->format('Y-m-d'),
            'calendarioInicial' => $this->disponibilidadCitasService->construirRespuestaDisponibilidad($mes),
            'fechaSeleccionada' => $fechaSeleccionada,
            'horasDisponibles' => $this->disponibilidadCitasService->obtenerHorasDisponibles($fechaSeleccionada),
        ]);
    }

    public function historial(Request $request): View
    {
        return view('citas.historial', [
            'citas' => $request->user()->citas()->with(['vehiculo', 'ordenTrabajo'])->latest('fecha')->get(),
        ]);
    }

    public function disponibilidad(Request $request)
    {
        $mes = $this->disponibilidadCitasService->obtenerMes($request->string('mes')->toString() ?: null);

        return response()->json($this->disponibilidadCitasService->construirRespuestaDisponibilidad($mes));
    }

    public function store(CrearCitaRequest $request): RedirectResponse
    {
        $vehiculo = $request->user()->vehiculos()->findOrFail($request->integer('vehiculoId'));

        $this->crearCitaAction->ejecutar($request->user(), [
            ...$request->validated(),
            'vehiculoId' => $vehiculo->id,
        ]);

        return redirect()
            ->route('citas.index', [
                'mes' => CarbonImmutable::parse($request->input('fecha'))->startOfMonth()->format('Y-m-d'),
            ])
            ->with('estado', 'cita-confirmada');
    }
}
