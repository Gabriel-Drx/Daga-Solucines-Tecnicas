<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        
      //  return $next($request);

       return redirect('/');
    }
}
