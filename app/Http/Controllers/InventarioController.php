<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $inventarios = Inventario::all();
            return ApiResponse::success("Listado de productos en Inventario", 200, $inventarios);
        } catch(Exception $e){
            return ApiResponse::error('Error al obtener los productos de Inventario: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|unique:inventarios|string|max:50|min:3',
                'cantidad' => 'required|numeric|gt:0',
                'cantidad_minima' => 'required|numeric|gt:0',
                'tipo' => 'required|in:Pescado,Bebida,Grano,Carne,Fruta,Verdura,Lacteo,Complemento,Condimiento,Crustáceo|string|max:100',
                'unidad_medida' => 'required|in:Litros,Kilogramos|string|max:10|min:5'
            ]);
            $inventario = Inventario::create(request()->all());
            return ApiResponse::success("Producto creado exitosamente a Inventario", 201, $inventario);
        } catch(ValidationException $errors){
            $errors = $errors->validator->errors()->toArray();
            return ApiResponse::error('Error al crear el producto de inventario: ', 422 , $errors);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $inventario = Inventario::findOrFail($id);
            return ApiResponse::success("Producto en Inventario", 200, $inventario);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Producto no encontrado de inventario', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $inventario = Inventario::findOrFail($id);
            $request->validate([
                'nombre' => 'required|string|max:50|min:3|unique:inventarios,nombre,' . $inventario->id,
                'cantidad' => 'required|numeric|gt:0',
                'cantidad_minima' => 'required|numeric|gt:0',
                'tipo' => 'required|in:Bebida,Grano,Carne,Fruta,Verdura,Lacteo,Complemento,Condimiento|string|max:100',
                'unidad_medida' => 'required|in:Litros,Kilogramos|string|max:10|min:3'
            ]);
            $inventario->update($request->all());
            return ApiResponse::success('Producto de Inventario actualizado exitosamente', 200, $inventario);
        } catch(ValidationException $errors){
            $errors = $errors->validator->errors()->toArray();
            return ApiResponse::error('Error al crear el producto de inventario: ' , 422 , $errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $inventario = Inventario::findOrFail($id);
            $inventario->delete();
            return ApiResponse::success('Producto eliminado de inventario exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Producto no encontrado de inventario', 404);
        }
    }
}
