<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServidorController;

Route::get('/servidores', [ServidorController::class, 'index']);
Route::patch('/servidores/{id}/levantar', [ServidorController::class, 'levantar']);
