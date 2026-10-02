<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaLimpieza extends Model
{
    use HasFactory;

    public const ESTADOS = ['Completo', 'Incompleto'];

    protected $table = 'tareas_limpieza';
    protected $primaryKey = 'id_limpieza';

    protected $fillable = [
        'fecha_limpieza',
        'estado_limpieza',
        'observaciones_limpieza',
        'id_usuario',
        'id_areas',
    ];

    protected $casts = [
        'fecha_limpieza' => 'datetime',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'id_areas', 'id_areas');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}