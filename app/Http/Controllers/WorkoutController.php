<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'exercise_id' => 'required|integer|exists:exercises,id',
            'repetitions' => 'required|integer',
            'weight' => 'required|numeric',
            'break_time' => 'required|integer',
            'day' => 'required|in:SEGUNDA,TERÇA,QUARTA,QUINTA,SEXTA,SÁBADO,DOMINGO',
            'observations' => 'sometimes|nullable|string',
            'time' => 'required|integer'
        ]);

        // Verifica se já existe um treino para o mesmo dia
        $existingWorkout = Workout::where('student_id', $validatedData['student_id'])
                                ->where('day', $validatedData['day'])
                                ->first();

        if ($existingWorkout) {
            return response()->json(['error' => 'Treino para o mesmo dia já cadastrado'], Response::HTTP_CONFLICT);
        }

        $workout = Workout::create($validatedData);
        return response()->json($workout, Response::HTTP_CREATED);

        return response()->json($workout, Response::HTTP_CREATED);
    }

    public function indexByStudent($studentId)
    {
        $workouts = Workout::with('exercise')
                        ->where('student_id', $studentId)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy('day');

        $student = Student::find($studentId);
        if (!$student) {
            return response()->json(['error' => 'Estudante não encontrado.'], Response::HTTP_NOT_FOUND);
        }

         // Inicializa um array com todos os dias da semana
    $allDays = [
        'SEGUNDA' => [],
        'TERÇA' => [],
        'QUARTA' => [],
        'QUINTA' => [],
        'SEXTA' => [],
        'SÁBADO' => [],
        'DOMINGO' => []
    ];

    // Preenche os dias com os treinos existentes
    foreach ($workouts as $day => $dayWorkouts) {
        $allDays[$day] = $dayWorkouts->pluck('exercise.description');
    }

    $response = [
        'student_id' => $student->id,
        'student_name' => $student->name,
        'workouts' => $allDays
    ];

    return response()->json($response, Response::HTTP_OK);
    }

}