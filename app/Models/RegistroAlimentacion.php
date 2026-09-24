<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroAlimentacion extends Model
{
    use HasFactory;

    protected $table = 'registros_alimentacion';
    protected $primaryKey = 'id_registros';

    protected $fillable = [
        'fecha_registro',
        'cantidad_administrada',
        'observaciones',
        'id_usuario',
        'id_dietas',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'cantidad_administrada' => 'decimal:2',
    ];

    public function dieta(): BelongsTo
    {
        return $this->belongsTo(Dieta::class, 'id_dietas', 'id_dietas');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}