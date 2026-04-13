<?php

namespace App\Modulos\Servicios\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modulos\Servicios\Models\Paquete;
use App\Modulos\Servicios\Models\Servicio;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogoServicioController extends Controller
{
    public function index(Request $request): View
    {
        $pestanaActiva = $request->string('pestana')->toString() === 'paquetes' ? 'paquetes' : 'servicios';

        return view('servicios.index', [
            'pestanaActiva' => $pestanaActiva,
            'servicios' => Servicio::query()->where('visible_catalogo', true)->where('activo', true)->get(),
            'paquetes' => Paquete::query()->where('visible_catalogo', true)->where('activo', true)->get(),
        ]);
    }
}
