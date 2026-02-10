<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServidorController;
use App\Http\Controllers\Api\InspeccionController;
use App\Http\Controllers\Api\AlertaController;

Route::get('/servidores', [ServidorController::class, 'index']);
Route::patch('/servidores/{id}/levantar', [ServidorController::class, 'levantar']);
Route::get('/inspeccion-servidor', [InspeccionController::class, 'investigar']);
Route::post('/alertas/kuma', [InspeccionController::class, 'procesar']);
