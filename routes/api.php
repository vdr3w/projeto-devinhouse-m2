<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas

    //LOGIN
    Route::post('logout', [AuthController::class, 'logout']);
});

// Rotas públicas que somente depois ficaram privadas

//USER
Route::post('users', [UserController::class, 'store']);


//LOGIN
Route::post('login', [AuthController::class, 'login']);
