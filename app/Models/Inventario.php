<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cantidad',
        'cantidad_minima',
        'tipo',
        'unidad_medida',
    ];

    public function inventarios()
    {
        return $this->belongsToMany(Inventario::class, 'platillo_inventario', 'id_platillo', 'id_inventario');
    }
    
}
