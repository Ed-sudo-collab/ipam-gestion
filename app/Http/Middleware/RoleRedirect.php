<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirect
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user->hasRole('ADMIN')) {
            return redirect()->route('dashboard'); // admin dashboard
        }

        if ($user->hasRole('SECRETAIRE')) {
            return redirect()->route('admin.students.index'); // page gestion étudiants
        }

        if ($user->hasRole('COMPTABLE')) {
            return redirect()->route('admin.tuitionFees.index'); // page frais/finance
        }

        // Par défaut, déconnecter ou rediriger vers login
        Auth::logout();
        return redirect()->route('login')->withErrors('Accès non autorisé.');
    }
}
