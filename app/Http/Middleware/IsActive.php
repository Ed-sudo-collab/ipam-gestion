<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->status !== 'ACTIVE') {
            abort(403, "Vous n'êtes pas autorisé à accéder à cette page.");
        }

        return $next($request);
    }
}
