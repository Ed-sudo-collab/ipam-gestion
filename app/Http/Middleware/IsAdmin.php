<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie que l'utilisateur est connecté et a le rôle ADMIN
        if (Auth::check() && Auth::user()->hasRole('ADMIN')) {
            return $next($request);
        }

        abort(403, 'Accès non autorisé.');
    }
}
