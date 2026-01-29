<?php
use App\Http\Controllers\Api\ServidorController;
use Illuminate\Support\Facades\Route;

Route::get('/servidores', [ServidorController::class, 'index']);
Route::patch('/servidores/{id}/levantar', [ServidorController::class, 'levantar']);
