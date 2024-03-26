<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Responses\ApiResponse;
use Exception;

class UseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();
            return ApiResponse::success("Listado de usuarios", 200, $users);
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener los usuarios: ' .$e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:20',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8'    
            ]);

            $validatedData['password'] = bcrypt($validatedData['password']);
            $user = User::create($request->all());
            return ApiResponse::success("Usuario creado exitosamente", 201, $user);
        } catch(Exception $e){
            return ApiResponse::error("Error al crear el usuario: ",422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
