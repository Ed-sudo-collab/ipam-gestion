<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ici on définit toutes les routes web avec Inertia
|
*/

// Page d'accueil
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Routes protégées par auth + jetstream
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Module Etudiants
    Route::get('/etudiants', function () {
        return Inertia::render('Etudiants/Index');
    })->name('etudiants.index');

    // Module Inscriptions
    // Module Inscriptions
    Route::get('/inscriptions', function () {
        return Inertia::render('Inscriptions/Index');
    })->name('inscriptions.index');

    // Module Paiements
    Route::get('/paiements', function () {
        return Inertia::render('Paiements/Index');
    })->name('paiements.index');



});


