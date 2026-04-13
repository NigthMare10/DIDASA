<?php

namespace App\Modulos\OrdenesTrabajo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class OrdenTrabajoController extends Controller
{
    public function index(): View
    {
        $ordenes = auth()->user()
            ->ordenesTrabajo()
            ->with(['vehiculo', 'eventos'])
            ->latest()
            ->get();

        return view('ordenes.index', [
            'ordenes' => $ordenes,
        ]);
    }
}
