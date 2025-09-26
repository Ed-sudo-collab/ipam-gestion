<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentController extends Controller
{
    // Liste étudiants
    public function index()
    {
        return view('admin.students.index'); // Vue avec Livewire Students
    }

    // Détails étudiant
    public function show($studentId)
    {
        $student = Student::findOrFail($studentId);

        return view('admin.students.student-show', compact('student')); // Vue parent Livewire
    }


    public function create()
{
    return view('admin.students.create');
}



}
