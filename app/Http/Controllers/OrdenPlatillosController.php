<?php

namespace App\Http\Controllers;
use App\Models\OrdenPlatillo;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Platillo;


class OrdenPlatillosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //$ordenPlatillos = OrdenPlatillo::all();
            $ordenPlatillos = OrdenPlatillo::with('orden' , 'platillo')->get();
            return ApiResponse::success("Listado de ordenes_platillos", 200, $ordenPlatillos);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener las ordenes_platillos: ' . $e->getMessage(), 500);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'orden_id' => 'required|numeric|min:1|exists:ordenes,id',
                'platillo_id' => 'required|numeric|min:1|exists:platillos,id',
                'cantidad' => 'required|numeric|min:1',
                'precio_platillo' => 'numeric|min:1',
            ]);

            $platillo = Platillo::find($request->platillo_id);
            $total = $platillo->precio * $request->cantidad;
            $request->merge(['precio_platillo' => $total]);

            $ordenPlatillos = OrdenPlatillo::create(request()->all());
            
            return ApiResponse::success("OrdenPlatillos creada exitosamente", 201, $ordenPlatillos);
        } catch (ValidationException $errors) {
            $errors = $errors->validator->errors()->getMessages();   
            return ApiResponse::error("Error al crear la ordenPlatillos: ", 422, $errors);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $ordenPlatillos = OrdenPlatillo::with('orden', 'platillo')->findOrFail($id);
            return ApiResponse::success("OrdenPlatillos encontrado", 200, $ordenPlatillos);
        } catch (Exception $e) {
            return ApiResponse::error('OrdenPlatillos no encontrado' , 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $ordenPlatillos = OrdenPlatillo::findOrFail($id);
            $request->validate([
                'orden_id' => 'required|numeric|min:1|exists:ordenes,id',
                'platillo_id' => 'required|numeric|min:1|exists:platillos,id',
                'cantidad' => 'required|numeric|min:1',
                'precio_platillo' => 'numeric|min:1',
            ]);

            $platillo = Platillo::find($request->platillo_id);
            $total = $platillo->precio * $request->cantidad;
            $request->merge(['precio_platillo' => $total]);

            $ordenPlatillos = OrdenPlatillo::findOrFail($id);
            $ordenPlatillos->update(request()->all());

            return ApiResponse::success("OrdenPlatillos actualizado exitosamente", 200, $ordenPlatillos);
        } catch (ValidationException $errors) {
            $errors = $errors->validator->errors()->getMessages();
            return ApiResponse::error("Error al actualizar la ordenPlatillos: ", 422, $errors);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('OrdenPlatillos no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::error('Error al actualizar la ordenPlatillos: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $ordenPlatillos = OrdenPlatillo::findOrFail($id);
            $ordenPlatillos->delete();
            return ApiResponse::success("OrdenPlatillos eliminado exitosamente", 200, $ordenPlatillos);
        } catch (Exception $e) {
            return ApiResponse::error('OrdenPlatillos no encontrado' , 404);
        }
    }
}
