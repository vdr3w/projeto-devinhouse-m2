<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
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

            return $user;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}