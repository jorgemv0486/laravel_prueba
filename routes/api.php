<?php

use App\Http\Controllers\API\MarcacionController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});



/*Route::get('marcaciones/{id}', [MarcacionController::class, 'obtenerMarcacion']);
Route::post('marcaciones', [MarcacionController::class, 'registrarMarcacion']);*/

Route::middleware(['auth:api'])->group(function () {
    Route::get('marcaciones/{id}', [MarcacionController::class, 'obtenerMarcacion']);
    Route::post('marcaciones', [MarcacionController::class, 'registrarMarcacion']);
});
