<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255'
        ], [
            'description.required' => 'A descrição é obrigatória.',
            'description.string' => 'A descrição deve ser uma string.',
            'description.max' => 'A descrição não pode ter mais que 255 caracteres.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        try {
            $user_id = $request->user()->id;
            $validatedData = $validator->validated();

            // Verifica se o exercício já está cadastrado para o usuário
            $existingExercise = Exercise::where('user_id', $user_id)
                                        ->where('description', $validatedData['description'])
                                        ->first();

            if ($existingExercise) {
                return response()->json(['error' => 'Exercício já cadastrado para este usuário'], Response::HTTP_CONFLICT);
            }

            // Criação do exercício
            $exercise = Exercise::create([
                'description' => $validatedData['description'],
                'user_id' => $user_id
            ]);

            return response()->json($exercise, Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(Request $request)
    {
        $user_id = Auth::id();
        $exercises = Exercise::where('user_id', $user_id)
                             ->orderBy('description')
                             ->get();

        return response()->json($exercises);
    }

    public function destroy($id)
    {
        $user_id = Auth::id();
        $exercise = Exercise::find($id);

        // Verifica se o exercício existe
        if (!$exercise) {
            return response()->json(['error' => 'Exercício não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        // Verifica se o exercício pertence ao usuário autenticado
        if ($exercise->user_id !== $user_id) {
            return response()->json(['error' => 'Ação não permitida.'], Response::HTTP_FORBIDDEN);
        }

        // Deleta o exercício
        $exercise->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
