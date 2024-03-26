<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platillo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen_path',
    ];

    public function platillo()
    {
        return $this->belongsToMany(Platillo::class, 'platillo_inventario', 'id_inventario', 'id_platillo');
    }
    
}
