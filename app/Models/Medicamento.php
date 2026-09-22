<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicamento extends Model
{
    use HasFactory;

    // Misma lista del enum de la migración; se reutiliza en validaciones y en el <select>
    public const TIPOS = ['medicamento', 'vacuna', 'vitamina'];
    public const TIPO_VACUNA = 'vacuna';
    public const TIPO_MEDICAMENTO = 'medicamento';

    protected $table = 'medicamentos';
    protected $primaryKey = 'id_medicamento';

    protected $fillable = [
        'nombre_medicamento',
        'tipo_medicamento',
        'stock_medicamento',
        'stock_minimo_medicamento',
        'unidad_medida_medicamento',
        'id_proveedores',
    ];

    protected $casts = [
        'stock_medicamento' => 'integer',
        'stock_minimo_medicamento' => 'integer',
    ];

    // TODO: requiere el modelo Proveedor (pendiente de confirmar quién lo crea)
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedores', 'id_proveedores');
    }

    public function procedimientos(): HasMany
    {
        return $this->hasMany(ProcedimientoClinico::class, 'id_medicamento', 'id_medicamento');
    }
}
