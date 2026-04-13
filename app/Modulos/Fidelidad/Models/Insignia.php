<?php

namespace App\Modulos\Fidelidad\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insignia extends Model
{
    protected $table = 'insignias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'criterio',
        'icono',
        'orden',
    ];

    protected function casts(): array
    {
        return [
            'orden' => 'integer',
        ];
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(UsuarioInsignia::class);
    }
}
