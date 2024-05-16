<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Rutas Login Autenticacion
Route::prefix('/v1/auth')->group(function(){
    Route::post('/login', [AuthController::class, "funLogin"]);
    Route::post('/register', [AuthController::class, "funRegistro"]);

    //para el token de acceso
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/perfil', [AuthController::class, "funPerfil"]);
        Route::post('/logout', [AuthController::class, "funSalir"]);
    });
});

Route::apiResource("categoria", CategoriaController::class);
Route::apiResource("producto", ProductoController::class);
