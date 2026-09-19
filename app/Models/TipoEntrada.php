<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoEntrada extends Model
{
    use HasFactory;

    protected $table = 'tipos_entrada';
    protected $primaryKey = 'id_tipo_entrada';

    protected $fillable = [
        'nombre_entrada',
        'precio_entrada',
    ];

    protected $casts = [
        'precio_entrada' => 'decimal:2',
    ];

    public function entradas(): HasMany
    {
        return $this->hasMany(Entrada::class, 'id_tipo_entrada', 'id_tipo_entrada');
    }
}