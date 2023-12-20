<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\SendWelcomeMailUser;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function store(Request $request) {
        try {
            $data = $request->all();

            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8|max:32',
                'date_birth' => 'required|date',
                'cpf' => 'required|unique:users|size:14',
                'plan_id' => 'required|exists:plans,id'
            ]);

            $user = User::create($data);

        // Obtém os detalhes do plano
        $plan = Plan::find($data['plan_id']);
        $planDescription = $plan->description; // Nome do plano
        $planLimit = $plan->limit; // Limite do plano

            // Envio do email
            Mail::to($data['email'])->send(new SendWelcomeMailUser($user->name, $planDescription, $planLimit));


            return $user;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}