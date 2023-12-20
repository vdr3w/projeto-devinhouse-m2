<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateLimitStudentsToUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next): Response
{
    $user = $request->user();
    $plan = $user->plan; // Carrega o plano associado ao usuário

    if ($plan) {
        $limit = $plan->limit; // Usa o limite definido no plano

        $studentCount = $user->students()->count();

        if ($limit !== null && $studentCount >= $limit) {
            return response()->json(['error' => 'O usuário atingiu o limite de cadastros para o plano.'], Response::HTTP_FORBIDDEN);
        }
    }

    return $next($request);
}
}