<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'auth' => function () {
                if (Auth::check()) {
                    // On charge les rôles pour l'utilisateur connecté
                    $user = Auth::user()->load('roles');
                    return [
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'roles' => $user->roles->map(fn($role) => [
                                'id' => $role->id,
                                'name' => $role->name,
                            ]),
                        ],
                    ];
                }

                return ['user' => null];
            }
        ]);
    }
}
