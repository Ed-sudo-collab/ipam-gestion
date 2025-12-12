<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\AcademicYear;
use App\Models\Program;
use App\Models\Level;

class Enrollments extends Component
{
    public $students;
    public $academicYears;
    public $programs;
    public $levels;

    public $student_id;
    public $academic_year_id;
    public $program_id;
    public $level_id;
    public $mode_etude;
    public $statut = "validee";

    public function mount()
    {
        $this->students       = Student::all();
        $this->academicYears  = AcademicYear::where('statut', 'actif')->get();
        $this->programs       = Program::all();
        $this->levels         = Level::all();

    }

    protected $rules = [
        'student_id'        => 'required|exists:students,id',
        'academic_year_id'  => 'required|exists:academic_years,id',
        'program_id'        => 'required|exists:programs,id',
        'level_id'          => 'required|exists:levels,id',
        'mode_etude'        => 'required|string',
        'statut'            => 'nullable|string'
    ];

    public function submit()
    {
        $this->validate();

        Enrollment::create([
            'student_id'       => $this->student_id,
            'academic_year_id' => $this->academic_year_id,
            'program_id'       => $this->program_id,
            'level_id'         => $this->level_id,
            'mode_etude'       => $this->mode_etude,
            'statut'           => $this->statut,
            'date_inscription' => now(),
        ]);

        session()->flash('success', 'Inscription enregistrée avec succès !');

        $this->reset(['student_id','academic_year_id','program_id','level_id','mode_etude']);
    }

    public function render()
    {
        return view('livewire.admin.enrollments');
    }
}
