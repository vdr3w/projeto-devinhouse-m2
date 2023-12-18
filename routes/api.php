<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas
});

// Rotas públicas que somente depois ficaram privadas

//USER
Route::post('users', [UserController::class, 'store']);
