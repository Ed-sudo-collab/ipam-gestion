<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes web avec Inertia et Jetstream
|
*/

// Page d'accueil
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => false, // Désactive l'inscription
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Routes protégées par auth + Jetstream
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Module Étudiants
    Route::get('/etudiants', function () {
        return Inertia::render('Etudiants/Index');
    })->name('etudiants.index');

    // Module Inscriptions
    Route::get('/inscriptions', function () {
        return Inertia::render('Inscriptions/Index');
    })->name('inscriptions.index');

    // Module Paiements
    Route::get('/paiements', function () {
        return Inertia::render('Paiements/Index');
    })->name('paiements.index');

    // 🔹 Gestion des utilisateurs (CRUD) pour ADMIN
    Route::prefix('users')->middleware('role:ADMIN')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

});
