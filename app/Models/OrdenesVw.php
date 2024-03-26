<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesVw extends Model
{
    use HasFactory;

    protected $table = 'ordenes_vw'; 

    // logic
    public static function getOrdenesVwData()
    {
       return static::all();
    }
}