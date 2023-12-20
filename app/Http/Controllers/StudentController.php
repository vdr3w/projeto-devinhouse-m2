<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:students',
        'date_birth' => 'required|date_format:Y-m-d',
        'cpf' => ['required', 'string', 'max:14', 'unique:students', 'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$|^\d{11}$/'],
        'contact' => 'required|string|max:20',
        // Campos opcionais
        'cep' => 'string|max:20|nullable',
        'street' => 'string|nullable',
        'state' => 'string|max:2|nullable',
        'neighborhood' => 'string|nullable',
        'city' => 'string|nullable',
        'number' => 'string|nullable',
        ]);

        $student = Student::create($validatedData + ['user_id' => Auth::id()]);
        return response()->json($student, Response::HTTP_CREATED);
    }

public function index(Request $request)
{
    $user = Auth::user();
    $students = $user->students()->orderBy('name')->get();

    $addStudentsAddress = $students->map(function ($student) {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'date_birth' => $student->date_birth,
            'cpf' => $student->cpf,
            'contact' => $student->contact,
            'user_id' => $student->user_id,
            'address' => [
                'city' => $student->city,
                'neighborhood' => $student->neighborhood,
                'number' => $student->number,
                'street' => $student->street,
                'state' => $student->state,
                'cep' => $student->cep
            ],
            'deleted_at' => $student->deleted_at
        ];
    });

    return response()->json($addStudentsAddress, Response::HTTP_OK);
}

    public function destroy($id)
    {
        $user_id = Auth::id();
        $student = Student::where('id', $id)->where('user_id', $user_id)->first();

        if (!$student) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }

        $student->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $student = Student::where('id', $id)->where('user_id', $user->id)->first();

        if (!$student) {
            return response()->json(['error' => 'Estudante não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:students,email,' . $id,
            'date_birth' => 'sometimes|date_format:Y-m-d',
            'cpf' => [
            'sometimes',
            'string',
            'unique:students,cpf,' . $id,
            'regex:/^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/'
        ],
            'contact' => [
            'sometimes',
            'string',
            'regex:/^\+?\d{2}\s?\d{4,5}-?\d{4}$/'
        ],
            'cep' => 'sometimes|string',
            'street' => 'sometimes|string',
            'state' => 'sometimes|string|max:2',
            'neighborhood' => 'sometimes|string',
            'city' => 'sometimes|string',
            'number' => 'sometimes|string',
        ]);

        $student->update($validatedData);

        return response()->json($student, Response::HTTP_OK);
    }

    private function formatCpf($cpf)
    {
        $cpf = preg_replace("/\D/", '', $cpf);
        return substr($cpf, 0, 3) . '.' .
            substr($cpf, 3, 3) . '.' .
            substr($cpf, 6, 3) . '-' .
            substr($cpf, 9, 2);
    }

    private function formatContact($contact)
    {
        $contact = preg_replace("/\D/", '', $contact);
        if (substr($contact, 0, 2) == '55') {
            $contact = substr($contact, 2);
        }
        return '(' . substr($contact, 0, 2) . ') ' .
            substr($contact, 2, 5) . '-' .
            substr($contact, 7, 4);
    }

    private function formatCep($cep)
    {
        $cep = preg_replace("/\D/", '', $cep);
        return substr($cep, 0, 2) . '.' .
            substr($cep, 2, 3) . '-' .
            substr($cep, 5, 3);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'Estudante não encontrado'], Response::HTTP_NOT_FOUND);
        }

        $response = [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'date_birth' => $student->date_birth,
                'cpf' => $this->formatCpf($student->cpf),
                'contact' => $this->formatContact($student->contact),
                'address' => [
                    'cep' => $this->formatCep($student->cep),
                    'street' => $student->street,
                    'province' => $student->state,
                    'neighborhood' => $student->neighborhood,
                    'city' => $student->city,
                    'complement' => $student->complement,
                    'number' => $student->number
            ]
        ];

        return response()->json($response, Response::HTTP_OK);
    }

public function exportPDF($id_do_estudante)
{
    $student = Student::with('workouts')->find($id_do_estudante);

    if (!$student) {
        return response()->json(['error' => 'Estudante não encontrado'], Response::HTTP_NOT_FOUND);
    }

    // Consulta todos os workouts relacionados a este estudante
    $workouts = Workout::where('student_id', $id_do_estudante)->get();

    // Para fins de depuração, você pode exibir os treinos no log
    foreach ($workouts as $workout) {
        \Log::info('Dia: ' . $workout->day);
        \Log::info('Descrição do Exercício: ' . $workout->exercise->description);
        // Adicione mais informações relevantes aqui, conforme necessário
    }

    $pdf = Pdf::loadView('pdf.student', compact('student', 'workouts'));
    return $pdf->download('treino-' . $student->name . '.pdf');
}

    }
