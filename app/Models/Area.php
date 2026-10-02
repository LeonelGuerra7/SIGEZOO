<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    public const TIPOS = ['jaula', 'sanitario', 'jardín', 'área de juegos', 'oficina'];

    protected $table = 'areas';
    protected $primaryKey = 'id_areas';

    protected $fillable = [
        'nombre_area',
        'tipo_area',
    ];

    public function tareasLimpieza(): HasMany
    {
        return $this->hasMany(TareaLimpieza::class, 'id_areas', 'id_areas');
    }
}