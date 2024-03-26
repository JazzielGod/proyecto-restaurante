<?php

namespace App\Http\Controllers;

use App\Models\Platillo;
use App\Http\Controllers\Controller;
use Exception;
use App\Http\Responses\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlatilloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $platillos = Platillo::all();
            return ApiResponse::success("Listado de platillos", 200, $platillos);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los platillos: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|unique:platillos|string|max:50|min:3',
                'descripcion' => 'required|string|max:100|min:10',
                'precio' => 'required|numeric|gt:0',
                'imagen_path' => 'mimes:jpeg,png,jpg,svg|max:51200',
            ]);
    
            $rutaDestino = '';
    
            if ($request->hasFile('imagen_path')) {
                $imagen = $request->file('imagen_path');
                $nombreImagen = $request->nombre . '.' . $imagen->getClientOriginalExtension();
                $rutaDestino = $nombreImagen;
                $imagen->move(public_path(''), $nombreImagen);
            }


            if($request->imagen_path == null){
                $rutaDestino = '/public/sushi.png';
            }
    
            $platillo = Platillo::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'imagen_path' => $rutaDestino,
            ]);
    
            $imagenUrl = $rutaDestino;
    
            return ApiResponse::success("Platillo creado exitosamente", 201, [
                'platillo' => $platillo,
                'imagen_url' => $imagenUrl,
            ]);
        } catch (ValidationException $errors) {
            return ApiResponse::error("Error al crear el platillo: ", 400, $errors->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Platillo no creado', 400);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $platillo = Platillo::findOrFail($id);
            return ApiResponse::success("Platillo encontrado", 200, $platillo);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Platillo no encontrado', 404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       try {
        $platillo = Platillo::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:50|min:3' . $request->id,
            'descripcion' => 'required|string|max:100|min:10',
            'precio' => 'required|numeric|gt:0',
            'imagen_path' => 'mimes:jpeg,png,jpg,svg|max:51200|nullable',
        ]);

        $rutaDestino = '';   

        if ($request->hasFile('imagen_path')) {
            $imagen = $request->file('imagen_path');
            $nombreImagen = $request->nombre . '.' . $imagen->getClientOriginalExtension();
            $rutaDestino = $nombreImagen;
            $imagen->move(public_path(''), $nombreImagen);
        }
        if($request->imagen_path == null){
            $rutaDestino = '/public/sushi.png';
        }

        $platillo->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagen_path' => $rutaDestino,
        ]);

        $imagenUrl = $rutaDestino;

        return ApiResponse::success("Platillo actualizado exitosamente", 200, [
            'platillo' => $platillo,
            'imagen_url' => $imagenUrl,
        ]);
       } catch (ValidationException $errors) {
        return ApiResponse::error("Error al actualizar el platillo: ", 400, $errors->errors());
       } catch (ModelNotFoundException $e) {
        return ApiResponse::error('Platillo no actualizado', 400);
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $platillo = Platillo::findOrFail($id);

            $imagen_path = $platillo->imagen_path;
            
            if ($imagen_path != ('sushi.png')) {
                $imagen_path = str_replace(('/public'), '', $imagen_path);
                if (file_exists(public_path($imagen_path))) {
                    unlink(public_path($imagen_path));
                }
            }
            $platillo->delete();
            return ApiResponse::success("Platillo eliminado exitosamente", 200, $platillo);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error("Platillo no encontrado", 404);
        }
    }
}
