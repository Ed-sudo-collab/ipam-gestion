<?php
// app/Livewire/Admin/StudentWizard.php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Student;
use App\Models\StudentAcademic;
use App\Models\StudentProfessional;
use App\Models\StudentDocument;
use Illuminate\Validation\Rule;

class StudentWizard extends Component
{
    use WithFileUploads;

    public $step = 1;

    // Étape 1
    public $nom, $prenom, $date_naissance, $lieu_naissance, $sexe, $telephone, $email;

    // Étape 2
    public $dernier_diplome, $etablissement, $annee_obtention, $mention;

    // Étape 3
    public $profession_actuelle, $employeur, $experience;

    // Étape 4
    public $documents = [];           // nouveaux fichiers uploadés
    public $existingDocuments = [];   // fichiers déjà en BDD

    public $mode = 'create';
    public $studentId;
    public $student;

    protected $listeners = ['refreshStudent' => 'loadStudent'];

    public function mount($studentId = null)
    {
        $this->studentId = $studentId;

        if ($this->studentId) {
            $this->mode = 'edit';
            $this->loadStudent();
        }
    }

    protected function rulesStep1()
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => [
                'required','email','max:255',
                Rule::unique('students','email')->ignore($this->studentId)
            ],
        ];
    }

    protected function validateStep()
    {
        if ($this->step == 1) {
            $this->validate($this->rulesStep1());
        }

        if ($this->step == 2) {
            $this->validate([
                'dernier_diplome' => 'nullable|string|max:255',
                'etablissement' => 'nullable|string|max:255',
                'annee_obtention' => 'nullable|date',
                'mention' => 'nullable|string|max:255',
            ]);
        }

        if ($this->step == 3) {
            $this->validate([
                'profession_actuelle' => 'nullable|string|max:255',
                'employeur' => 'nullable|string|max:255',
                'experience' => 'nullable|string',
            ]);
        }

        if ($this->step == 4) {
            $this->validate([
                'documents.*' => 'file|max:5120',
            ]);
        }
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->step++;
    }

    public function prevStep()
    {
        $this->step = max(1, $this->step - 1);
    }

    public function save()
    {
        // validation finale
        $this->validateStep();

        if ($this->mode === 'create') {
            $student = Student::create([
                'user_id' => auth()->id(),
                'matricule' => 'MAT-' . time(),
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'date_naissance' => $this->date_naissance,
                'lieu_naissance' => $this->lieu_naissance,
                'sexe' => $this->sexe,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'statut_id' => 1,
            ]);
        } else {
            $student = Student::findOrFail($this->studentId);
            $student->update([
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'date_naissance' => $this->date_naissance,
                'lieu_naissance' => $this->lieu_naissance,
                'sexe' => $this->sexe,
                'telephone' => $this->telephone,
                'email' => $this->email,
            ]);
        }

        // académique
        $student->academic()->updateOrCreate(
            ['student_id' => $student->id],
            [
                'dernier_diplome' => $this->dernier_diplome,
                'etablissement' => $this->etablissement,
                'annee_obtention' => $this->annee_obtention,
                'mention' => $this->mention,
            ]
        );

        // professionnel
        $student->professional()->updateOrCreate(
            ['student_id' => $student->id],
            [
                'profession_actuelle' => $this->profession_actuelle,
                'employeur' => $this->employeur,
                'experience' => $this->experience,
            ]
        );

        // documents (nouveaux)
        foreach ($this->documents as $file) {
            $storedPath = $file->store('students', 'public');
            StudentDocument::create([
                'student_id' => $student->id,
                'path' => $storedPath,
                'filename' => $file->getClientOriginalName(),
            ]);
        }

        session()->flash('message', 'Étudiant enregistré avec succès ✅');

        return redirect()->route('admin.students.show', $student->id);
    }

    public function loadStudent()
    {
        $this->student = Student::with(['academic', 'professional', 'documents'])->find($this->studentId);

        if (! $this->student) {
            return;
        }

        // étape 1
        $this->nom = $this->student->nom;
        $this->prenom = $this->student->prenom;
        $this->date_naissance = $this->student->date_naissance;
        $this->lieu_naissance = $this->student->lieu_naissance;
        $this->sexe = $this->student->sexe;
        $this->telephone = $this->student->telephone;
        $this->email = $this->student->email;

        // étape 2
        if ($this->student->academic) {
            $this->dernier_diplome = $this->student->academic->dernier_diplome;
            $this->etablissement = $this->student->academic->etablissement;
            $this->annee_obtention = $this->student->academic->annee_obtention;
            $this->mention = $this->student->academic->mention;
        }

        // étape 3
        if ($this->student->professional) {
            $this->profession_actuelle = $this->student->professional->profession_actuelle;
            $this->employeur = $this->student->professional->employeur;
            $this->experience = $this->student->professional->experience;
        }

        // étape 4 (existants)
        $this->existingDocuments = $this->student->documents->map(fn($d) => [
            'id' => $d->id,
            'path' => $d->path,
            'filename' => $d->filename,
        ])->toArray();
    }

    public function render()
    {
        return view('livewire.admin.student-wizard');
    }
}
