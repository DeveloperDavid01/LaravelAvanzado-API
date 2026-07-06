<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// 1. Importamos tus controladores (Ajusta la carpeta si están dentro de API)
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\API\UserTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Ruta pública para obtener el Token (El endpoint que creamos antes)
Route::post('/sanctum/token', [UserTokenController::class, 'store']);

// 2. Agrupamos todas las rutas que requieren autenticación para tener un código más limpio
Route::middleware('auth:sanctum')->group(function () {
    
    // Endpoint por defecto para conocer el usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Recursos protegidos usando la sintaxis correcta de Laravel 8+
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    
    // Ruta para destruir el token (Logout)
    Route::post('/sanctum/logout', [UserTokenController::class, 'destroy']);
});