<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\{
    Dashboard,
    UserController,
    RoleController,
    LevelController,
    ProgramController,
    AcademicYearController,
    StudentController,
    StudentStatutController,
    EnrollmentController,
    TuitionFeeController,
    TuitionInstallmentController,
    PayementController,
    FinanceController,
    PaymentHistoriq,
    ReportController
};
use App\Http\Middleware\IsActive;
use App\Http\Middleware\RoleRedirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================
// Page publique
// =========================
Route::get('/', function () {
    return view('auth.login');
});


// =========================
// Dashboard et redirection (auth + rôles)
// =========================
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = Auth::user();

    if ($user->hasRole('ADMIN')) {
        return app(Dashboard::class)->index(); // ADMIN → dashboard
    }

    if ($user->hasRole('SECRETAIRE')) {
        return redirect()->route('admin.students.index'); // SECRETAIRE → gestion étudiants
    }

    if ($user->hasRole('COMPTABLE')) {
        return redirect()->route('admin.tuitionFees.index'); // COMPTABLE → gestion frais
    }

    // Aucun rôle reconnu → logout
    Auth::logout();
    return redirect()->route('login')->withErrors('Accès non autorisé.');
})->name('dashboard');

// =========================
// ADMIN – TOUTES LES ROUTES (SANS RESTRICTION DE RÔLE)
// =========================
Route::middleware(['auth', IsActive::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | UTILISATEURS & RÔLES
        |--------------------------------------------------------------------------
        */
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
        Route::patch('users/{user}/block', [UserController::class, 'blockUser'])
            ->name('users.block');

        Route::resource('roles', RoleController::class);

        /*
        |--------------------------------------------------------------------------
        | GESTION ACADÉMIQUE
        |--------------------------------------------------------------------------
        */
        Route::get('levels', [LevelController::class, 'index'])->name('levels.index');
        Route::get('programs', [ProgramController::class, 'index'])->name('programs.index');
        Route::get('academic-years', [AcademicYearController::class, 'index'])->name('academicYears.index');
        Route::get('student-statut', [StudentStatutController::class, 'index'])->name('studentStatut.index');

        /*
        |--------------------------------------------------------------------------
        | ÉTUDIANTS
        |--------------------------------------------------------------------------
        */
        Route::get('students', [StudentController::class, 'index'])->name('students.index');
        Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
        Route::get('students/{studentId}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::get('students/{studentId}', [StudentController::class, 'show'])->name('students.show');

        /*
        |--------------------------------------------------------------------------
        | INSCRIPTIONS
        |--------------------------------------------------------------------------
        */
        Route::get('enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('enrollments/{enrollmentId}/attestation', [EnrollmentController::class, 'attestation'])
            ->name('enrollments.attestation');

        /*
        |--------------------------------------------------------------------------
        | FRAIS & ÉCHÉANCES
        |--------------------------------------------------------------------------
        */
        Route::get('tuition-fees', [TuitionFeeController::class, 'index'])->name('tuitionFees.index');
        Route::get('tuition-installments', [TuitionInstallmentController::class, 'index'])->name('tuitionInstallments.index');

        /*
        |--------------------------------------------------------------------------
        | PAIEMENTS & FINANCE
        |--------------------------------------------------------------------------
        */
        Route::get('payements', [PayementController::class, 'index'])->name('payements.index');
        Route::get('finance', [FinanceController::class, 'index'])->name('finance.index');

        Route::get('payment-historiq', [PaymentHistoriq::class, 'index'])->name('paymentHistoriq.index');
        Route::get('payment-historiq/{paymentId}', [PaymentHistoriq::class, 'show'])->name('paymentHistoriq.show');
        Route::get('payment-historiq/{paymentId}/receipt', [PayementController::class, 'receipt'])
            ->name('payment.receipt');

        /*
        |--------------------------------------------------------------------------
        | RAPPORTS & EXPORTS
        |--------------------------------------------------------------------------
        */
        Route::get('reports/students', [ReportController::class, 'students'])->name('reports.students');
        Route::get('reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
        Route::get('reports/student/{student}', [ReportController::class, 'studentFinancial'])
            ->name('reports.student.financial');
    });
