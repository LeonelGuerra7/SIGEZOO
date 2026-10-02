<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promociones';
    protected $primaryKey = 'id_promociones';

    protected $fillable = [
        'nombre_promociones',
        'descripcion',
        'descuento_porcentaje',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'descuento_porcentaje' => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function entradas(): HasMany
    {
        return $this->hasMany(Entrada::class, 'id_promociones', 'id_promociones');
    }

    /**
     * Solo promociones vigentes hoy.
     */
    public function scopeVigentes($query)
    {
        $hoy = now()->toDateString();

        return $query->whereDate('fecha_inicio', '<=', $hoy)
                      ->whereDate('fecha_fin', '>=', $hoy);
    }
}