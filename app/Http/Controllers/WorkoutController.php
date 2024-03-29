<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use App\Models\Exercise;
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

// Obtém a descrição do exercício pelo ID
    $exerciseDescription = Exercise::where('id', $validatedData['exercise_id'])->first()->description;

    // Verifica se já existe um treino para o mesmo dia com o mesmo exercício (por descrição)
    $existingWorkout = Workout::whereHas('exercise', function ($query) use ($exerciseDescription) {
                                $query->where('description', $exerciseDescription);
                            })
                            ->where('student_id', $validatedData['student_id'])
                            ->where('day', $validatedData['day'])
                            ->first();

    if ($existingWorkout) {
        return response()->json(['error' => "Exercício '{$exerciseDescription}' para o mesmo dia já cadastrado para este aluno"], Response::HTTP_CONFLICT);
    }

    // Cria um novo treino se não existir conflito
    $workout = Workout::create($validatedData);
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

    public function exportPDF($id_do_estudante)
    {
        $student = Student::find($id_do_estudante);

        if (!$student) {
            return response()->json(['error' => 'Estudante não encontrado'], Response::HTTP_NOT_FOUND);
        }

        // Consulta todos os workouts relacionados a este estudante
        $workouts = Workout::where('student_id', $id_do_estudante)->get();

        $pdf = Pdf::loadView('pdf.student', compact('student', 'workouts'));
        return $pdf->download('treino-' . $student->name . '.pdf')->stream('relatorio.pdf');
    }
}
