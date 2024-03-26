<?php

namespace App\Http\Controllers;

use App\Models\PlatilloInventario;
use App\Http\Controllers\Controller;
use Exception;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Inventario;

class PlatilloInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $platilloInventario = PlatilloInventario::with('platillo', 'inventario')->get();
            return ApiResponse::success("Listado de platilloInventario", 200, $platilloInventario);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener la información: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_platillo' => 'required|exists:platillos,id',
                'id_inventario' => 'required|exists:inventarios,id',
                'cantidad' => 'required|numeric|min:1',
            ]);

            // Obtener el inventario correspondiente
            $inventario = Inventario::find($request->id_inventario);

            // Verificar si hay suficiente cantidad de inventario
            if ($inventario->cantidad < $request->cantidad) {
                return ApiResponse::error("Cantidad no disponible", 422);
            }

            // Restar la cantidad de inventario
            $inventario->decrement('cantidad', $request->cantidad);

            $platilloInventario = PlatilloInventario::create($request->all());

            return ApiResponse::success("PlatilloInventario creado exitosamente", 201, $platilloInventario);
        } catch (ValidationException $errors) {
            $errors = $errors->validator->errors()->toArray();
            if (isset($errors['id_platillo'])) {
                $errors['platillo'] = $errors['id_platillo'];
                unset($errors['id_platillo']);
            }
            if (isset($errors['id_inventario'])) {
                $errors['inventario'] = $errors['id_inventario'];
                unset($errors['id_inventario']);
            }
            return ApiResponse::error("Error al crear Platilloinventario: ", 422, $errors);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('PlatilloInventario no creado', 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $platilloInventario = PlatilloInventario::with('platillo', 'inventario')->findOrFail($id);
            return ApiResponse::success("PlatilloInventario encontrado", 200, $platilloInventario);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los datos' , 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $platilloinventario = PlatilloInventario::findOrFail($id);
            $request->validate([
                'id_platillo' => 'required|exists:platillos,id',
                'id_inventario' => 'required|exists:inventarios,id',
                'cantidad' => 'required|numeric|min:1',
            ]);

            // Obtener el inventario correspondiente
            $inventario = Inventario::find($request->id_inventario);

            // Verificar si hay suficiente cantidad de inventario
            if ($inventario->cantidad < $request->cantidad) {
                return ApiResponse::error("Cantidad no disponible", 422);
            }

            // Restar la cantidad de inventario
            $inventario->decrement('cantidad', $request->cantidad);

            $platilloinventario->update($request->all());
            return ApiResponse::success("PlatilloInventario actualizado exitosamente", 200, $platilloinventario);
        } catch (ValidationException $errors) {
            $errors = $errors->validator->errors()->toArray();
            if (isset($errors['id_platillo'])) {
                $errors['platillo'] = $errors['id_platillo'];
                unset($errors['id_platillo']);
            }
            if (isset($errors['id_inventario'])) {
                $errors['inventario'] = $errors['id_inventario'];
                unset($errors['id_inventario']);
            }
            return ApiResponse::error("Error al actualizar Platilloinventario: ", 422, $errors);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('PlatilloInventario no actualizado', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $platilloinventario = PlatilloInventario::findOrFail($id);
            $platilloinventario->delete();
            return ApiResponse::success("PlatilloInventario eliminado exitosamente", 200, $platilloinventario);
        } catch (Exception $e) {
            return ApiResponse::error('Error al eliminar el platilloinventario', 500);
        }
    }
}
