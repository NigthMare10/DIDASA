<?php

namespace App\Modulos\Fidelidad\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioInsignia extends Model
{
    protected $table = 'usuario_insignia';

    protected $fillable = [
        'user_id',
        'insignia_id',
        'obtenida_en',
    ];

    protected function casts(): array
    {
        return [
            'obtenida_en' => 'datetime',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function insignia(): BelongsTo
    {
        return $this->belongsTo(Insignia::class);
    }
}
