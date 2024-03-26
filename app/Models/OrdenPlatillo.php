<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenPlatillo extends Model
{
    use HasFactory;

    protected $table = 'orden_platillos';
    
    protected $fillable = [
        'orden_id',
        'platillo_id',
        'cantidad',
        'precio_platillo',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function platillo()
    {
        return $this->belongsTo(Platillo::class, 'platillo_id');
    }
}
