<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // Vérifie si l'utilisateur est connecté et a la permission
        if (!auth()->check() || !auth()->user()->can($permission)) {
            abort(403, 'Action non autorisée.');
        }

        return $next($request);
    }
}


