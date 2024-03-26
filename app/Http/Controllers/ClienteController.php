<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Responses\ApiResponse;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clientes = Cliente::all();
            return ApiResponse::success("Listado de clientes", 200, $clientes);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los clientes: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        try {
            $request->validate([
                'nombre' => 'required|string|max:50|min:3',
                'apellido' => 'string|max:100|min:3',
                'email' => 'required|string|max:100|email|regex:/^.+@.+$/i|unique:clientes,email,',
                'telefono' => 'required|numeric|max:9999999999|min:1000000000|unique:clientes,telefono',
            ]);
            $cliente = Cliente::create($request->all());
            return ApiResponse::success("Cliente creado exitosamente", 201, $cliente);
        } catch(ValidationException $errors){
            $errors = $errors->validator->errors()->toArray();
            return ApiResponse::error('Error al crear el cliente: ', 422 , $errors);
        }
    }   

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            return ApiResponse::success("Cliente encontrado", 200, $cliente);
        } catch (Exception $e) {
            return ApiResponse::error('Cliente no encontrado' , 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $request->validate([
                'nombre' => 'required|string|max:50' . $cliente->id,
                'apellido' => 'string|max:100|min:3',
                'email' => 'required|string|max:100|email|regex:/^.+@.+$/i|unique:clientes,email,' . $cliente->id,
                'telefono' => 'required|numeric|max:9999999999|min:1000000000|unique:clientes,telefono,' . $cliente->id,
            ]);
            $cliente->update($request->all());
            return ApiResponse::success("Cliente actualizado exitosamente", 200, $cliente);
        }  catch(ValidationException $errors){
            $errors = $errors->validator->errors()->toArray();
            return ApiResponse::error('Error al actualizar el cliente: ' , 422 , $errors);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();
            return ApiResponse::success("Cliente eliminado exitosamente", 200, $cliente);
        } catch (Exception $e) {
            return ApiResponse::error('Cliente no encontrado' , 404);
        }
    }
}
