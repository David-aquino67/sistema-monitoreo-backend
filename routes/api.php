<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServidorController;
use App\Http\Controllers\Api\InspeccionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\DatosLoginMiddleware;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
	Route::post('/login', 'login')->middleware([DatosLoginMiddleware::class]);
 	Route::get('logout', 'logout')->middleware(['auth:sanctum']);
	Route::get('validate/token', 'validateToken')->middleware(['auth:sanctum']);
    Route::get('validate/user/{id_usuario}', 'existeUsuario');
});

Route::prefix('global')->controller(GlobalController::class)->group(function () {
	Route::get('/versiones', 'indexVersiones')->middleware(['auth:sanctum']);
	Route::get('/versiones/ultima', 'showUltimaVersion')->middleware(['auth:sanctum']);
	Route::get('/versiones/{version}', 'showVersion')->middleware(['auth:sanctum']);
	Route::delete('/cache', 'destroyCache')->middleware(['auth:sanctum', 'ability:admin']);
});

Route::prefix('usuarios')->controller(UsuarioController::class)->group(function () {
	Route::get('/', 'index')->middleware(['auth:sanctum']);
	Route::get('/search', 'search')->middleware(['auth:sanctum', 'ability:admin']);
	Route::get('/{id_sibop}', 'show')->middleware(['auth:sanctum', 'ability:admin']);
	Route::post('/', 'store')->middleware(['auth:sanctum', 'ability:admin']);
	Route::put('/{id_sibop}', 'update')->middleware(['auth:sanctum', 'ability:admin']);
	Route::delete('/{id_sibop}', 'destroy')->middleware(['auth:sanctum', 'ability:admin']);
});


Route::get('/servidores', [ServidorController::class, 'index']);
Route::patch('/servidores/{id}/levantar', [ServidorController::class, 'levantar']);
Route::post('/inspeccion-servidor', [InspeccionController::class, 'investigar']);
Route::post('/alertas/kuma', [InspeccionController::class, 'procesar']);
