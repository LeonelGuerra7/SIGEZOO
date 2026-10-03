<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    use HasFactory;

    public const SEXOS = ['Macho', 'Hembra'];
    public const ESTADOS = ['Saludable', 'En tratamiento', 'Cuarentena', 'Lesionado', 'Fallecido'];

    protected $table = 'animales';
    protected $primaryKey = 'id_animal';

    protected $fillable = [
        'nombre_animal',
        'especie_animal',
        'fecha_nacimiento_animal',
        'sexo_animal',
        'estado_animal',
        'id_areas',
        'id_dietas',
    ];

    protected $casts = [
        'fecha_nacimiento_animal' => 'date',
    ];

    public function procedimientosClinicos(): HasMany
    {
        return $this->hasMany(ProcedimientoClinico::class, 'id_animal', 'id_animal');
    }

    public function habitat(): BelongsTo
    {
        return $this->belongsTo(Habitat::class, 'id_areas');
    }

    public function dieta(): BelongsTo
    {
        return $this->belongsTo(Dieta::class, 'id_dietas');
    }
}