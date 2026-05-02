<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Ruta para que otros microservicios validen tokens
Route::middleware('auth:sanctum')->get('/user-verify', function (Request $request) 
{
    return response()->json([
        'valid' => true,
        'user' => [
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
        ]
    ]);
});

// Ruta pública para el login
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas 
Route::middleware('auth:sanctum')->group(function () 
{

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

});

