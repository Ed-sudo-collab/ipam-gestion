<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\IsActive;
use App\Http\Middleware\IsAdmin;

Route::get('/', function () {
    return view('welcome');
});

// Onglet Dashboard – accessible uniquement aux utilisateurs connectés et actifs
Route::middleware(['auth', IsActive::class])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

// Onglet Utilisateurs – accessible uniquement aux ADMIN
Route::middleware(['auth', IsActive::class, IsAdmin::class])
    ->get('/admin/users', function () {
        // On affichera la vue Livewire dédiée à la gestion des utilisateurs
        return view('admin.users.index');
    })
    ->name('admin.users.index');

// CRUD complet des utilisateurs via UserController (routes RESTful)
Route::middleware(['auth', IsActive::class, IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
    });
