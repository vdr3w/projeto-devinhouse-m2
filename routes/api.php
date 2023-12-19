<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth:sanctum')->group(function () {
// rotas privadas

//LOGOUT
Route::post('logout', [AuthController::class, 'logout']);

//DASHBOARD
Route::get('dashboard', [DashboardController::class, 'index']);

//EXERCISES
Route::post('exercises', [ExerciseController::class, 'store']);
Route::get('exercises', [ExerciseController::class, 'index']);
Route::delete('exercises/{id}', [ExerciseController::class, 'destroy']);

//ESTUDANTES
Route::get('students', [StudentController::class, 'index']);
Route::delete('students/{id}', [StudentController::class, 'destroy']);
Route::put('students/{id}', [StudentController::class, 'update']);
Route::post('students', [StudentController::class, 'store'])->middleware('validateLimitStudents');


});

// Rotas públicas que somente depois ficaram privadas

//USER
Route::post('users', [UserController::class, 'store']);

//LOGIN
Route::post('login', [AuthController::class, 'login']);