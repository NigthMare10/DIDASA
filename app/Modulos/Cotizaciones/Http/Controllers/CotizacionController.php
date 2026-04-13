<?php

namespace App\Modulos\Cotizaciones\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modulos\Compartido\Enums\EstadoCotizacion;
use App\Modulos\Cotizaciones\Actions\CrearCotizacionAction;
use App\Modulos\Cotizaciones\Http\Requests\CrearCotizacionRequest;
use App\Modulos\Cotizaciones\Models\Cotizacion;
use App\Modulos\Servicios\Models\Paquete;
use App\Modulos\Servicios\Models\Servicio;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CotizacionController extends Controller
{
    public function __construct(private readonly CrearCotizacionAction $crearCotizacionAction)
    {
    }

    public function index(): View
    {
        return view('cotizaciones.index', [
            'vehiculos' => auth()->user()->vehiculos()->orderBy('marca')->get(),
            'servicios' => Servicio::query()->where('activo', true)->orderBy('nombre')->get(),
            'paquetes' => Paquete::query()->where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function historial(): View
    {
        return view('cotizaciones.historial', [
            'cotizaciones' => auth()->user()->cotizaciones()->with(['vehiculo', 'items'])->latest()->get(),
        ]);
    }

    public function store(CrearCotizacionRequest $request): RedirectResponse
    {
        $vehiculo = $request->user()->vehiculos()->findOrFail($request->integer('vehiculoId'));

        $cotizacion = $this->crearCotizacionAction->ejecutar($request->user(), [
            ...$request->validated(),
            'vehiculoId' => $vehiculo->id,
        ]);

        return redirect()
            ->route('cotizaciones.historial')
            ->with('estado', 'cotizacion-enviada')
            ->with('referenciaCotizacion', $cotizacion->numero_cotizacion);
    }

    public function actualizarEstado(Request $request, Cotizacion $cotizacion): RedirectResponse
    {
        abort_unless($cotizacion->user_id === $request->user()->id, 403);

        $datos = $request->validate([
            'estado' => ['required', Rule::in([
                EstadoCotizacion::Aprobada->value,
                EstadoCotizacion::Rechazada->value,
            ])],
        ]);

        $cotizacion->update(['estado' => $datos['estado']]);

        \activity()
            ->causedBy($request->user())
            ->performedOn($cotizacion)
            ->event('cotizacion_'.$datos['estado'])
            ->log('Cotizacion actualizada por el cliente');

        return redirect()
            ->route('cotizaciones.historial')
            ->with('estado', $datos['estado'] === EstadoCotizacion::Aprobada->value ? 'cotizacion-aprobada' : 'cotizacion-rechazada');
    }
}
