<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatilloInventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_platillo',
        'id_inventario',
        'cantidad',
    ];

    public function platillo()
    {
        return $this->belongsTo(Platillo::class, 'id_platillo');
    }
    
    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }
}
