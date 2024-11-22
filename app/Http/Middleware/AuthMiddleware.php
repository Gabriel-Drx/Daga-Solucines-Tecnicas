<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('nombre')) { // O el dato que estás guardando en la sesión cuando el usuario se logea
            return redirect()->route('principal'); // Redirigir a la página de login
        }

        return $next($request); // Permitir acceso si está logeado
    }
}
