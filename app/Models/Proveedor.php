<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedores';

    protected $fillable = [
        'nombre_proveedor',
        'numero_proveedor',
        'email_proveedor',
    ];

    public function alimentos(): HasMany
    {
        return $this->hasMany(Alimento::class, 'id_proveedores', 'id_proveedores');
    }
}