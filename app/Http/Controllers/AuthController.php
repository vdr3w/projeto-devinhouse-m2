<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request) {
        try {
            $data = $request->only('email', 'password');

            $request->validate([
                'email' => 'email|required',
                'password' => 'string|required'
            ]);

            if (!Auth::attempt($data)) {
                return $this->error('Credenciais inválidas', Response::HTTP_UNAUTHORIZED);
            }

            // Deleta os tokens antigos (apenas do usuário que fez a requisição)
            $user = $request->user();
            $user->tokens()->delete();

            // Após deletar, cria um novo token, para não acumular
            $token = $user->createToken('simple')->plainTextToken;

            return $this->response('Login realizado com sucesso', Response::HTTP_OK, [
                'name' => $user->name,
                'token' => $token
            ]);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request){
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->response('Logout realizado com sucesso', Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_NO_CONTENT);
        }
    }
}
