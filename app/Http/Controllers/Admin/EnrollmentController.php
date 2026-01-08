<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
         public function index()
    {
        return view('admin.enrollments.index');
    }


    /**
     * 📜 Génération de l'attestation d'inscription
     * (version simple, sans logique métier)
     */
    public function attestation($enrollmentId)
    {
        $enrollment = Enrollment::with([
            'student',
            'academicYear',
            'program',
            'level',
        ])->findOrFail($enrollmentId);

        return view('admin.enrollments.attestation', compact('enrollment'));
    }

}
