<?php

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

    // Étape 1 - Informations générales
    public $nom, $prenom, $matricule, $date_naissance, $lieu_naissance, $sexe, $telephone, $email;
    public $situation_matrimoniale, $nombre_enfants, $adresse, $telephone_parent;

    // Étape 2 - Informations académiques
    public $dernier_diplome, $etablissement, $annee_obtention, $mention, $path_diplome, $path_releves;
    public $diplome_file, $releves_file;

    // Étape 3 - Informations professionnelles
    public $profession_actuelle, $employeur, $experience;

    // Étape 4 - Documents
    public $documents = [];
    public $existingDocuments = [];

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
            'telephone' => 'nullable|string|max:20',
            'situation_matrimoniale' => 'nullable|string|max:50',
            'nombre_enfants' => 'nullable|integer|min:0',
            'adresse' => 'nullable|string|max:255',
            'telephone_parent' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|in:M,F',
        ];
    }

    protected function rulesStep2()
    {
        return [
            'dernier_diplome' => 'nullable|string|max:255',
            'etablissement' => 'nullable|string|max:255',
            'annee_obtention' => 'nullable|integer|digits:4',
            'mention' => 'nullable|string|max:255',
            'diplome_file' => 'nullable|file|max:5120',
            'releves_file' => 'nullable|file|max:5120',
        ];
    }

    protected function rulesStep3()
    {
        return [
            'profession_actuelle' => 'nullable|string|max:255',
            'employeur' => 'nullable|string|max:255',
            'experience' => 'nullable|string',
        ];
    }

    protected function rulesStep4()
    {
        return [
            'documents.*' => 'file|max:5120',
        ];
    }

    protected function validateStep()
    {
        if ($this->step == 1) $this->validate($this->rulesStep1());
        if ($this->step == 2) $this->validate($this->rulesStep2());
        if ($this->step == 3) $this->validate($this->rulesStep3());
        if ($this->step == 4) $this->validate($this->rulesStep4());
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
        // Validation finale
        $this->validateStep();

        // Étudiant
        if ($this->mode === 'create') {
            $student = Student::create([
                'user_id' => auth()->id(),
                'matricule' => $this->matricule ?? 'MAT-' . time(),
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'date_naissance' => $this->date_naissance,
                'lieu_naissance' => $this->lieu_naissance,
                'sexe' => $this->sexe,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'situation_matrimoniale' => $this->situation_matrimoniale,
                'nombre_enfants' => $this->nombre_enfants ?? 0,
                'adresse' => $this->adresse,
                'telephone_parent' => $this->telephone_parent,
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
                'situation_matrimoniale' => $this->situation_matrimoniale,
                'nombre_enfants' => $this->nombre_enfants,
                'adresse' => $this->adresse,
                'telephone_parent' => $this->telephone_parent,
            ]);
        }

        // Académique
        $academicData = [
            'dernier_diplome' => $this->dernier_diplome,
            'etablissement' => $this->etablissement,
            'annee_obtention' => $this->annee_obtention,
            'mention' => $this->mention,
        ];

        if ($this->diplome_file) {
            $academicData['path_diplome'] = $this->diplome_file->store('students/diplomes', 'public');
        }
        if ($this->releves_file) {
            $academicData['path_releves'] = $this->releves_file->store('students/releves', 'public');
        }

        $student->academic()->updateOrCreate(
            ['student_id' => $student->id],
            $academicData
        );

        // Professionnel
        $student->professional()->updateOrCreate(
            ['student_id' => $student->id],
            [
                'profession_actuelle' => $this->profession_actuelle,
                'employeur' => $this->employeur,
                'experience' => $this->experience,
            ]
        );

        // Documents supplémentaires
        foreach ($this->documents as $file) {
            $storedPath = $file->store('students/documents', 'public');
            StudentDocument::create([
                'student_id' => $student->id,
                'path' => $storedPath,
                'type_document' => 'autre',
            ]);
        }

        session()->flash('message', 'Étudiant enregistré avec succès ✅');
        return redirect()->route('admin.students.show', $student->id);
    }

    public function loadStudent()
    {
        $this->student = Student::with(['academic', 'professional', 'documents'])->find($this->studentId);
        if (!$this->student) return;

        // Étape 1
        foreach (['nom','prenom','matricule','date_naissance','lieu_naissance','sexe','telephone','email','situation_matrimoniale','nombre_enfants','adresse','telephone_parent'] as $field) {
            $this->$field = $this->student->$field;
        }

        // Étape 2
        if ($this->student->academic) {
            foreach (['dernier_diplome','etablissement','annee_obtention','mention','path_diplome','path_releves'] as $field) {
                $this->$field = $this->student->academic->$field;
            }
        }

        // Étape 3
        if ($this->student->professional) {
            foreach (['profession_actuelle','employeur','experience'] as $field) {
                $this->$field = $this->student->professional->$field;
            }
        }

        // Étape 4
        $this->existingDocuments = $this->student->documents->map(fn($d) => [
            'id' => $d->id,
            'path' => $d->path,
            'filename' => basename($d->path),
            'type_document' => $d->type_document,
        ])->toArray();
    }

    public function render()
    {
        return view('livewire.admin.student-wizard');
    }
}
