<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\AcademicYear;
use App\Models\Program;
use App\Models\Level;
use App\Models\StudentStatut;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Enrollments extends Component
{
    // 🔹 Listes pour le formulaire et les filtres
    public $students;
    public $academicYears;
    public $programs;
    public $levels;

    // 🔹 Champs formulaire
    public $student_id;
    public $academic_year_id;
    public $program_id;
    public $level_id;
    public $mode_etude = 'presentiel';
    public $statut = 'en_cours_paiement';

    // 🔹 Filtres dynamiques
    public $filter_search = '';
    public $filter_statut = '';
    public $filter_academic_year = '';
    public $filter_level = '';
    public $filter_program = '';

    // 🔹 Modal
    public $showModal = false;

    // 🔹 Liste des inscriptions
    public $enrollments;

    /**
     * Initialisation
     */
    public function mount()
    {
        $this->students      = Student::with('statut')->get();
        $this->academicYears = AcademicYear::where('statut', 'actif')->get();
        $this->programs      = Program::all();
        $this->levels        = Level::all();

        $this->loadEnrollments();
    }

    /**
     * Règles de validation
     */
    protected $rules = [
        'student_id'        => 'required|exists:students,id',
        'academic_year_id'  => 'required|exists:academic_years,id',
        'program_id'        => 'required|exists:programs,id',
        'level_id'          => 'required|exists:levels,id',
        'mode_etude'        => 'required|in:presentiel,en_ligne',
        'statut'            => 'required|in:en_attente,validee,en_cours_paiement,terminee',
    ];

    /**
     * Soumission du formulaire
     */
    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $exists = Enrollment::where('student_id', $this->student_id)
                ->where('academic_year_id', $this->academic_year_id)
                ->exists();

            if ($exists) {
                session()->flash('error', 'Cet étudiant est déjà inscrit pour cette année académique.');
                DB::rollBack();
                return;
            }

            Enrollment::create([
                'student_id'       => $this->student_id,
                'academic_year_id' => $this->academic_year_id,
                'program_id'       => $this->program_id,
                'level_id'         => $this->level_id,
                'mode_etude'       => $this->mode_etude,
                'statut'           => $this->statut,
                'date_inscription' => now(),
            ]);

            $statutInscrit = StudentStatut::firstOrCreate(
                ['libelle' => 'Inscrit'],
                ['type' => 'systeme', 'modifiable' => false]
            );

            Student::where('id', $this->student_id)
                ->update(['statut_id' => $statutInscrit->id]);

            DB::commit();

            session()->flash('success', 'Inscription effectuée et statut étudiant mis à jour.');

            $this->reset(['student_id', 'academic_year_id', 'program_id', 'level_id', 'mode_etude']);
            $this->showModal = false;

            $this->loadEnrollments();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de l’inscription.');
        }
    }

    /**
     * Charger les inscriptions avec filtres
     */
    public function loadEnrollments()
    {
        $this->enrollments = Enrollment::with(['student.statut', 'academicYear', 'program', 'level'])
            ->when($this->filter_search, function (Builder $q) {
                $q->whereHas('student', function (Builder $sq) {
                    $sq->where('nom', 'like', "%{$this->filter_search}%")
                       ->orWhere('prenom', 'like', "%{$this->filter_search}%")
                       ->orWhere('matricule', 'like', "%{$this->filter_search}%");
                });
            })
            ->when($this->filter_statut, fn($q) => $q->where('statut', $this->filter_statut))
            ->when($this->filter_academic_year, fn($q) => $q->where('academic_year_id', $this->filter_academic_year))
            ->when($this->filter_level, fn($q) => $q->where('level_id', $this->filter_level))
            ->when($this->filter_program, fn($q) => $q->where('program_id', $this->filter_program))
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Annuler une inscription
     */
    public function cancelEnrollment($id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            session()->flash('error', "Inscription introuvable.");
            return;
        }

        $enrollment->statut = 'annulee';
        $enrollment->save();

        session()->flash('success', "Inscription annulée avec succès.");

        $this->loadEnrollments();
    }

    /**
     * Toggle modal
     */
    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }





    public function updated($property)
    {
        if (str_starts_with($property, 'filter_')) {
            $this->loadEnrollments();
        }
    }





    /**
     * Rendu de la vue
     */
    public function render()
    {
        return view('livewire.admin.enrollments');
    }
}
