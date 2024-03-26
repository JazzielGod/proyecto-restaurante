<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = [
        'mesa',
        'tipo_orden',
        'direccion',
        'fecha',     
        'id_cliente',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
