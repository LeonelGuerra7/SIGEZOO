<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habitat extends Model
{
    use HasFactory;

    protected $table = 'areas';
    protected $primaryKey = 'id_areas';

    protected $fillable = [
        'nombre_area',
        'tipo_area',
    ];

    public function animales(): HasMany
    {
        return $this->hasMany(Animal::class, 'id_areas', 'id_areas');
    }
}
