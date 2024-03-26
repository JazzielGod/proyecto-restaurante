<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\OrdenesVw;


class OrdenesVwController extends Controller
{
    public function index()
    {
        try {
            $ordenes = OrdenesVw::all();
            return ApiResponse::success("Listado de ordenes view", 200, $ordenes);
        } catch(Exception $e){
            return ApiResponse::error('Error al obtener las ordenes view: ' .$e->getMessage(), 500);
        }
    }


}
