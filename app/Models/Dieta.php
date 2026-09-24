<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dieta extends Model
{
    use HasFactory;

    protected $table = 'dietas';
    protected $primaryKey = 'id_dietas';

    protected $fillable = [
        'nombre_dieta',
        'cantidad_dieta',
        'frecuencia',
        'fecha_distribucion',
        'id_alimentos',
    ];

    protected $casts = [
        'cantidad_dieta' => 'integer',
        'fecha_distribucion' => 'datetime',
    ];

    public function alimento(): BelongsTo
    {
    return $this->belongsTo(Alimento::class, 'id_alimentos');
    }

    public function registros(): HasMany
    {
        return $this->hasMany(RegistroAlimentacion::class, 'id_dietas', 'id_dietas');
    }
}