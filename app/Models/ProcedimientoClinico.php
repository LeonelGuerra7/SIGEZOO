<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcedimientoClinico extends Model
{
    use HasFactory;

    protected $table = 'procedimientos_clinicos';
    protected $primaryKey = 'id_procedimientos_clinicos';

    protected $fillable = [
        'fecha_aplicacion',
        'fecha_proxima',
        'observaciones_procedimiento',
        'id_animal',
        'id_usuario',
        'id_medicamento',
    ];

    protected $casts = [
        'fecha_aplicacion' => 'datetime',
        'fecha_proxima' => 'date',
    ];

    // TODO: requiere el modelo Animal (Rol 3)
    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'id_animal', 'id_animal');
    }

    public function medicamento(): BelongsTo
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento', 'id_medicamento');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
