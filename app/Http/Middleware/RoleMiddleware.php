<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Maneja una petición entrante.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Verificamos si el usuario ha iniciado sesión
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Verificamos si el 'tipo_usuario' del usuario está dentro de los roles autorizados
        if (!in_array(Auth::user()->tipo_usuario, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
