<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Middleware\IsActive;
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Dashboard – accessible uniquement aux utilisateurs connectés et actifs
Route::middleware(['auth', IsActive::class])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

// Routes Admin – accessible uniquement aux ADMIN et utilisateurs actifs
Route::middleware(['auth', IsActive::class, IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // -----------------------------
        // Utilisateurs
        // -----------------------------
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
        Route::patch('users/{user}/block', [UserController::class, 'blockUser'])
            ->name('users.block');

        // -----------------------------
        // Rôles
        // -----------------------------
        Route::resource('roles', RoleController::class);

        // -----------------------------
        // Permissions (à venir)
        // -----------------------------
        // Route::resource('permissions', PermissionController::class);
    });
