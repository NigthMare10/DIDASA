<?php

namespace App\Modulos\Portal\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class InicioController extends Controller
{
    public function __invoke(): View
    {
        return view('portal.inicio', [
            'categorias' => config('didasa.categoriasInicio'),
            'beneficios' => config('didasa.beneficiosInicio'),
            'pasos' => config('didasa.pasosInicio'),
            'contacto' => config('didasa.contacto'),
        ]);
    }
}
