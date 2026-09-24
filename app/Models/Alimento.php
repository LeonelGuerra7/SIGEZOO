<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alimento extends Model
{
    use HasFactory;

    public const TIPOS = [
        'carne', 'pescado', 'forraje', 'concentrado', 'fruta',
        'verdura', 'semillas', 'insectos', 'suplemento',
    ];

    protected $table = 'alimentos';
    protected $primaryKey = 'id_alimientos';

    protected $fillable = [
        'nombre_alimento',
        'tipo_alimento',
        'stock_alimento',
        'stock_minimo_alimento',
        'unidad_medida_alimento',
        'id_proveedores',
    ];

    protected $casts = [
        'stock_alimento' => 'integer',
        'stock_minimo_alimento' => 'integer',
    ];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedores', 'id_proveedores');
    }

    public function dietas(): HasMany
    {
        return $this->hasMany(Dieta::class, 'id_alimentos', 'id_alimentos');
    }

    public function stockBajo(): bool
    {
        return $this->stock_alimento <= $this->stock_minimo_alimento;
    }
}