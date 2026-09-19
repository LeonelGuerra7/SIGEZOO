<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrada extends Model
{
    use HasFactory;

    protected $table = 'entradas';
    protected $primaryKey = 'id_entradas';

    protected $fillable = [
        'fecha_visita',
        'cantidad_entrada',
        'total',
        'estado_pago',
        'fecha_compra',
        'id_tipo_entrada',
        'id_promociones',
        'id_usuario',
    ];

    protected $casts = [
        'fecha_visita' => 'date',
        'fecha_compra' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function tipoEntrada(): BelongsTo
    {
        return $this->belongsTo(TipoEntrada::class, 'id_tipo_entrada', 'id_tipo_entrada');
    }

    public function promocion(): BelongsTo
    {
        return $this->belongsTo(Promocion::class, 'id_promociones', 'id_promociones');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'id_usuario');
    }
}