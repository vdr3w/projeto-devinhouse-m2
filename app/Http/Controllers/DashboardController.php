<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $amountStudents = $user->students()->count();
            $amountExercises = $user->exercises()->count();

            $userPlan = $user->plan;
            $planName = $userPlan->description; // Usando a descrição do plano
            $planLimit = $userPlan->limit; // Usando o limite do plano

            $remainingStudents = is_null($planLimit) ? null : max(0, $planLimit - $amountStudents);

            return response()->json([
                'registered_students' => $amountStudents,
                'registered_exercises' => $amountExercises,
                'current_user_plan' => $planName,
                'remaining_students' => $remainingStudents
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}