<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    public const ADMINISTRADOR = 'administrador';
    public const OPERATIVO = 'operativo';
    public const VISITANTE = 'visitante';

    protected $table = 'roles';
    protected $primaryKey = 'id_rol';

    protected $fillable = [
        'rol_nombre',
        'rol_descripcion',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_rol', 'id_rol');
    }
}
