<?php

namespace App\Http\Middleware;

use App\Models\AclRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Middleware personalizado para la administración 
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            Auth::check() &&
            Auth::user()->puedePermiso('administrador') ||
            Auth::user()->puedePermiso('jugador')
        ) {
            return $next($request);
        }
        return response(View('errors.401'));
    }
}


