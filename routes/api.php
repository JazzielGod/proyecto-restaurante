<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PlatilloController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlatilloInventarioController;
use App\Http\Controllers\UseController;
use App\Http\Controllers\OrdenPlatillosController;
use App\Http\Controllers\OrdenesVwController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::apiresource('inventarios', InventarioController::class);
Route::apiResource('platillos', PlatilloController::class);
Route::apiResource('ordenes', OrdenController::class);
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('platillosInventarios', PlatilloInventarioController::class);
Route::apiResource('users', UseController::class);
Route::apiResource('ordenesPlatillos', OrdenPlatillosController::class);
Route::apiResource('ordenes_vw', OrdenesVwController::class);