<?php

namespace App\Modulos\Vehiculos\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modulos\Vehiculos\Actions\RegistrarVehiculoAction;
use App\Modulos\Vehiculos\Http\Requests\RegistrarVehiculoRequest;
use App\Modulos\Vehiculos\Models\Vehiculo;
use App\Modulos\Vehiculos\Services\ConstruirCarnetSaludVehiculoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class VehiculoController extends Controller
{
    public function __construct(
        private readonly RegistrarVehiculoAction $registrarVehiculoAction,
        private readonly ConstruirCarnetSaludVehiculoService $construirCarnetSaludVehiculoService,
    ) {
    }

    public function index(): View
    {
        return view('vehiculos.index', [
            'vehiculos' => auth()->user()->vehiculos()->with(['cotizaciones', 'citas', 'ordenesTrabajo'])->latest()->get(),
        ]);
    }

    public function showCarnet(Vehiculo $vehiculo): View
    {
        $this->authorize('view', $vehiculo);

        return view('vehiculos.carnet', [
            'vehiculo' => $vehiculo,
            ...$this->construirCarnetSaludVehiculoService->ejecutar($vehiculo),
        ]);
    }

    public function exportarCarnetPdf(Vehiculo $vehiculo)
    {
        $this->authorize('view', $vehiculo);

        $pdf = Pdf::loadView('vehiculos.carnet-pdf', [
            'vehiculo' => $vehiculo,
            ...$this->construirCarnetSaludVehiculoService->ejecutar($vehiculo),
        ])->setPaper('a4');

        return $pdf->download('carnet-salud-'.$vehiculo->placa.'.pdf');
    }

    public function store(RegistrarVehiculoRequest $request): RedirectResponse
    {
        $this->registrarVehiculoAction->ejecutar($request->user(), $request->validated());

        return redirect()
            ->route('vehiculos.index')
            ->with('estado', 'vehiculo-registrado');
    }

    public function destroy(Vehiculo $vehiculo): RedirectResponse
    {
        $this->authorize('delete', $vehiculo);

        $vehiculo->delete();

        return redirect()
            ->route('vehiculos.index')
            ->with('estado', 'vehiculo-eliminado');
    }
}
