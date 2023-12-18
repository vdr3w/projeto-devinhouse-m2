<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth:sanctum')->group(function () {
// rotas privadas

//LOGOUT
Route::post('logout', [AuthController::class, 'logout']);

//DASHBOARD
Route::get('dashboard', [DashboardController::class, 'index']);
});

// Rotas públicas que somente depois ficaram privadas

//USER
Route::post('users', [UserController::class, 'store']);

//LOGIN
Route::post('login', [AuthController::class, 'login']);
