<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Vérifie que l'utilisateur connecté possède le rôle demandé.
     *
     * Usage dans les routes :
     * ->middleware('role:ADMIN')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string    $role
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (Auth::check() && Auth::user()->hasRole($role)) {
            return $next($request);
        }

        abort(403, 'Accès non autorisé.');
    }
}
