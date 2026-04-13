<?php

namespace App\Modulos\Fidelidad\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoPunto extends Model
{
    protected $table = 'movimientos_puntos';

    protected $fillable = [
        'user_id',
        'tipo',
        'descripcion',
        'puntos',
        'saldo_resultante',
        'origen_tipo',
        'origen_id',
    ];

    protected function casts(): array
    {
        return [
            'puntos' => 'integer',
            'saldo_resultante' => 'integer',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
