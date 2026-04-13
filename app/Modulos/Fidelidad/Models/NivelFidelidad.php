<?php

namespace App\Modulos\Fidelidad\Models;

use Illuminate\Database\Eloquent\Model;

class NivelFidelidad extends Model
{
    protected $table = 'niveles_fidelidad';

    protected $fillable = [
        'nombre',
        'slug',
        'puntos_minimos',
        'descuento_porcentaje',
        'color',
        'icono',
        'orden',
    ];

    protected function casts(): array
    {
        return [
            'puntos_minimos' => 'integer',
            'descuento_porcentaje' => 'integer',
            'orden' => 'integer',
        ];
    }
}
