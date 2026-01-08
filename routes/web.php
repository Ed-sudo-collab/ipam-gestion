<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentStatutController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\PayementController;
use App\Http\Controllers\Admin\TuitionFeeController;
use App\Http\Controllers\Admin\TuitionInstallmentController;
use App\Http\Controllers\Admin\PaymentHistoriq;
use App\Http\Middleware\IsActive;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\CheckPermission;
use App\Models\StudentStatut;

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


// =========================
// Routes Admin strictes (ADMIN ONLY)
// =========================
Route::middleware(['auth', IsActive::class, IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // -----------------------------
        // Utilisateurs
        // -----------------------------
        Route::resource('users', UserController::class)
            ->middleware(CheckPermission::class . ':gestion.utilisateur');

        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->middleware(CheckPermission::class . ':gestion.utilisateur')
            ->name('users.toggle-status');

        Route::patch('users/{user}/block', [UserController::class, 'blockUser'])
            ->middleware(CheckPermission::class . ':gestion.utilisateur')
            ->name('users.block');

        // -----------------------------
        // Rôles
        // -----------------------------
        Route::resource('roles', RoleController::class)
            ->middleware(CheckPermission::class . ':gestion.roles');

        // -----------------------------
        // Niveaux
        // -----------------------------
        Route::get('levels', [LevelController::class, 'index'])
            ->middleware(CheckPermission::class . ':manage-levels')
            ->name('levels.index');

        // -----------------------------
        // Programmes
        // -----------------------------
        Route::get('programs', [ProgramController::class, 'index'])
            ->middleware(CheckPermission::class . ':manage-programs')
            ->name('programs.index');

        // -----------------------------
        // Années académiques
        // -----------------------------
        Route::get('academic-years', [AcademicYearController::class, 'index'])
            ->middleware(CheckPermission::class . ':manage-academic-years')
            ->name('academicYears.index');


        Route::get('student-statut', [StudentStatutController::class, 'index'])
            ->name('studentStatut.index');







    });





// =========================
// Routes accessibles à ADMIN + SECRETAIRE
// =========================
Route::middleware(['auth', IsActive::class, CheckPermission::class . ':manage-students'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Liste étudiants (Livewire Students)
        Route::get('students', [StudentController::class, 'index'])
            ->name('students.index');

        // Création via wizard
        Route::get('students/create', [StudentController::class, 'create'])
            ->name('students.create');

        // Edition via wizard
        Route::get('students/{studentId}/edit', [StudentController::class, 'edit'])
            ->name('students.edit');

        // Détails (lecture seule)
        Route::get('students/{studentId}', [StudentController::class, 'show'])
            ->name('students.show');


        // ➕ Nouvelle route pour l’inscription
        Route::get('enrollments', [EnrollmentController::class, 'index'])
            ->name('enrollments.index');


        /// 📜 Attestation d'inscription
        Route::get('/enrollments/{enrollmentId}/attestation', [EnrollmentController::class, 'attestation'])
            ->name('enrollments.attestation');



        //Gestion des frais de scolarité
        Route::get('tuition-fees', [TuitionFeeController::class, 'index'])
            ->name('tuitionFees.index');


        //Gestion des échéances
        Route::get('tuition-installments', [TuitionInstallmentController::class, 'index'])
            ->name('tuitionInstallments.index');


        //Gestion des payements
        Route::get('payements', [PayementController::class, 'index'])
            ->name('payements.index');


        //Situation financière
        Route::get('finance', [FinanceController::class, 'index'])
            ->name('finance.index');

        // 📄 Historique des paiements
        Route::get('/payment-historiq', [PaymentHistoriq::class, 'index'])
            ->name('paymentHistoriq.index');


        // 📄 Reçu d'un payement
        Route::get('/payment-historiq/{paymentId}/receipt', [PayementController::class, 'receipt'])
            ->name('payment.receipt');


        // 🔍 Détail d’un paiement
        Route::get('/payment-historiq/{paymentId}', [PaymentHistoriq::class, 'show'])
            ->name('paymentHistoriq.show');

    });
