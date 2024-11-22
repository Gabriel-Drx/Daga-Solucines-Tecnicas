<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;


class CheckUserSession
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('usuario')) {
            return redirect('dashboard2');
        }

        return $next($request);
    }
}