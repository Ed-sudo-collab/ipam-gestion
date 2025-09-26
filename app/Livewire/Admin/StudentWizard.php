<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Student;
use App\Models\StudentAcademic;
use App\Models\StudentProfessional;
use App\Models\StudentDocument;

class StudentWizard extends Component
{
    use WithFileUploads;

    public $step = 1;

    // Étape 1 - Infos générales
    public $nom, $prenom, $date_naissance, $lieu_naissance, $sexe, $telephone, $email;

    // Étape 2 - Académique
    public $dernier_diplome, $etablissement, $annee_obtention, $mention;

    // Étape 3 - Professionnel
    public $profession_actuelle, $employeur, $experience;

    // Étape 4 - Documents
    public $documents = [];

    public $mode = 'create';
    public $studentId;
    public $student;

    public function mount($studentId = null)
    {
        $this->studentId = $studentId;

        if ($this->studentId) {
            $this->loadStudent();
            $this->mode = 'edit';
        }
    }

    protected function validateStep()
    {
        if ($this->step == 1) {
            $rules = [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email' . ($this->studentId ? ',' . $this->studentId : ''),
            ];
            $this->validate($rules);
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
                'documents.*' => 'file|max:5120', // max 5MB
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
        $this->step--;
    }

    public function save()
    {
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
                'statut_id' => 1, // par défaut
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

        // Académique
        $student->academic()->updateOrCreate([], [
            'dernier_diplome' => $this->dernier_diplome,
            'etablissement' => $this->etablissement,
            'annee_obtention' => $this->annee_obtention,
            'mention' => $this->mention,
        ]);

        // Professionnel
        $student->professional()->updateOrCreate([], [
            'profession_actuelle' => $this->profession_actuelle,
            'employeur' => $this->employeur,
            'experience' => $this->experience,
        ]);

        // Documents
        foreach ($this->documents as $file) {
            $storedPath = $file->store('students', 'public');

            StudentDocument::create([
                'student_id' => $student->id,
                'path' => $storedPath, // <-- obligatoire
                'filename' => $file->getClientOriginalName(),
            ]);
        }

        session()->flash('message', 'Étudiant enregistré avec succès ✅');

        return redirect()->route('admin.students.show', $student->id);
    }

    public function loadStudent()
    {
        $this->student = Student::with(['academic', 'professional', 'documents'])->find($this->studentId);

        if ($this->student) {
            $this->nom = $this->student->nom;
            $this->prenom = $this->student->prenom;
            $this->date_naissance = $this->student->date_naissance;
            $this->lieu_naissance = $this->student->lieu_naissance;
            $this->sexe = $this->student->sexe;
            $this->telephone = $this->student->telephone;
            $this->email = $this->student->email;

            if ($this->student->academic) {
                $this->dernier_diplome = $this->student->academic->dernier_diplome;
                $this->etablissement = $this->student->academic->etablissement;
                $this->annee_obtention = $this->student->academic->annee_obtention;
                $this->mention = $this->student->academic->mention;
            }

            if ($this->student->professional) {
                $this->profession_actuelle = $this->student->professional->profession_actuelle;
                $this->employeur = $this->student->professional->employeur;
                $this->experience = $this->student->professional->experience;
            }

            $this->documents = $this->student->documents->map(fn($d) => $d->path)->toArray();
        }
    }

    public function render()
    {
        return view('livewire.admin.student-wizard');
    }
}
