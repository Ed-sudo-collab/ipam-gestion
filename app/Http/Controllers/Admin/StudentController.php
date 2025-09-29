<?php
// app/Http/Controllers/Admin/StudentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        return view('admin.students.index');
    }

    public function show($studentId)
    {
        $student = Student::findOrFail($studentId);
        return view('admin.students.student-show', compact('student'));
    }

    public function create()
    {
        // création pure — pas d'étudiant
        return view('admin.students.create', ['studentId' => null]);
    }

    public function edit($studentId)
    {
        // en édition on fournit l'id au template afin que le composant Livewire charge les données
        return view('admin.students.create', ['studentId' => $studentId]);
    }
}
