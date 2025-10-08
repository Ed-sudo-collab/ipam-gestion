<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\StudentDocument;
use App\Models\StudentStatut;

class StudentWizard extends Component
{
    use WithFileUploads;

    public $step = 1;

    // ---------- Step 1 : Infos générales ----------
    public $nom;
    public $prenom;
    public $matricule;
    public $date_naissance;
    public $lieu_naissance;
    public $sexe;
    public $telephone;
    public $email;
    public $situation_matrimoniale;
    public $nombre_enfants;
    public $adresse;
    public $telephone_parent;

    // ---------- Step 2 : Infos académiques ----------
    public $dernier_diplome;
    public $etablissement;
    public $annee_obtention;
    public $mention;
    public $diplome_file;
    public $releves_file;
    public $existingDiplome;
    public $existingReleves;

    // ---------- Step 3 : Infos professionnelles ----------
    public $profession_actuelle;
    public $employeur;
    public $experience;

    // ---------- Step 4 : Documents ----------
    public $acte_naissance_file;
    public $diplome_doc_file;
    public $lettre_motivation_file;
    public $cv_file;
    public $photo_file;
    public $cni_file;

    public $documents;

    // Mode et identifiant
    public $mode = 'create';
    public $studentId; // 🔥 cohérent avec la route et la vue
    public $student;

    protected $listeners = ['refreshStudent' => 'loadStudent'];

    /**
     * mount() : reçoit $studentId depuis la vue Blade
     */
    public function mount($studentId = null)
    {
        $this->studentId = $studentId;
        $this->documents = collect();

        if ($this->studentId) {
            $this->mode = 'edit';
            $this->loadStudent();
        }
    }

    /**
     * Validation rules
     */
    protected function rulesStep1()
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:50',
            'date_naissance' => 'nullable|date',
        ];
    }

    protected function rulesStep2()
    {
        return [
            'dernier_diplome' => 'nullable|string|max:255',
            'etablissement' => 'nullable|string|max:255',
            'annee_obtention' => 'nullable|digits:4',
            'mention' => 'nullable|string|max:255',
            'diplome_file' => 'nullable|file|max:10240',
            'releves_file' => 'nullable|file|max:10240',
        ];
    }

    protected function rulesStep3()
    {
        return [
            'profession_actuelle' => 'nullable|string|max:255',
            'employeur' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:2000',
        ];
    }

    protected function rulesStep4()
    {
        return [
            'acte_naissance_file' => 'nullable|file|max:10240',
            'diplome_doc_file' => 'nullable|file|max:10240',
            'lettre_motivation_file' => 'nullable|file|max:10240',
            'cv_file' => 'nullable|file|max:10240',
            'photo_file' => 'nullable|image|max:5120',
            'cni_file' => 'nullable|file|max:10240',
        ];
    }

    protected function validateStep()
    {
        match ($this->step) {
            1 => $this->validate($this->rulesStep1()),
            2 => $this->validate($this->rulesStep2()),
            3 => $this->validate($this->rulesStep3()),
            4 => $this->validate($this->rulesStep4()),
        };
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->step = min(4, $this->step + 1);
    }

    public function prevStep()
    {
        $this->step = max(1, $this->step - 1);
    }

    /**
     * Enregistrement global (create ou update)
     */
    public function save()
    {
        $this->validateStep();

        $statut = StudentStatut::firstOrCreate(['libelle' => 'Préinscrit']);

        if (!$this->studentId) {
            // Création
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
                'statut_id' => $statut->id,
            ]);

            $this->studentId = $student->id;
            $this->mode = 'edit';
        } else {
            // Mise à jour
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

        // Infos académiques
        $academicData = [
            'dernier_diplome' => $this->dernier_diplome,
            'etablissement' => $this->etablissement,
            'annee_obtention' => $this->annee_obtention,
            'mention' => $this->mention,
        ];

        // Gestion fichiers académiques
        if ($this->diplome_file) {
            if (!empty($this->existingDiplome) && Storage::disk('public')->exists($this->existingDiplome)) {
                Storage::disk('public')->delete($this->existingDiplome);
            }
            $academicData['path_diplome'] = $this->diplome_file->store('students/diplomes', 'public');
            $this->existingDiplome = $academicData['path_diplome'];
            $this->diplome_file = null;
        } else {
            $academicData['path_diplome'] = $this->existingDiplome;
        }

        if ($this->releves_file) {
            if (!empty($this->existingReleves) && Storage::disk('public')->exists($this->existingReleves)) {
                Storage::disk('public')->delete($this->existingReleves);
            }
            $academicData['path_releves'] = $this->releves_file->store('students/releves', 'public');
            $this->existingReleves = $academicData['path_releves'];
            $this->releves_file = null;
        } else {
            $academicData['path_releves'] = $this->existingReleves;
        }

        $student->academic()->updateOrCreate(['student_id' => $student->id], $academicData);

        // Professionnel
        $student->professional()->updateOrCreate(
            ['student_id' => $student->id],
            [
                'profession_actuelle' => $this->profession_actuelle,
                'employeur' => $this->employeur,
                'experience' => $this->experience,
            ]
        );

        // Documents
        $docMap = [
            'acte_naissance' => $this->acte_naissance_file,
            'diplome' => $this->diplome_doc_file,
            'lettre_motivation' => $this->lettre_motivation_file,
            'cv' => $this->cv_file,
            'photo' => $this->photo_file,
            'cni' => $this->cni_file,
        ];

        foreach ($docMap as $type => $file) {
            if ($file) {
                $existing = StudentDocument::where('student_id', $student->id)
                    ->where('type_document', $type)
                    ->first();

                if ($existing) {
                    if (Storage::disk('public')->exists($existing->path)) {
                        Storage::disk('public')->delete($existing->path);
                    }
                    $existing->delete();
                }

                $path = $file->store('students/documents', 'public');
                StudentDocument::create([
                    'student_id' => $student->id,
                    'type_document' => $type,
                    'path' => $path,
                ]);

                $this->{$type . '_file'} = null;
            }
        }

        $this->loadStudent();

        session()->flash('message', 'Étudiant enregistré avec succès ✅');

        return redirect()->route('admin.students.show', $student->id);
    }

    /**
     * Précharger les données
     */
    public function loadStudent()
    {
        if (!$this->studentId) {
            $this->student = null;
            return;
        }

        $this->student = Student::with(['academic', 'professional', 'documents'])->find($this->studentId);
        if (!$this->student) return;

        // Step 1
        foreach (['nom','prenom','matricule','date_naissance','lieu_naissance','sexe','telephone','email','situation_matrimoniale','nombre_enfants','adresse','telephone_parent'] as $f) {
            $this->$f = $this->student->$f;
        }

        // Step 2
        if ($this->student->academic) {
            foreach (['dernier_diplome','etablissement','annee_obtention','mention'] as $f) {
                $this->$f = $this->student->academic->$f;
            }
            $this->existingDiplome = $this->student->academic->path_diplome;
            $this->existingReleves = $this->student->academic->path_releves;
        }

        // Step 3
        if ($this->student->professional) {
            foreach (['profession_actuelle','employeur','experience'] as $f) {
                $this->$f = $this->student->professional->$f;
            }
        }

        // Step 4
        $this->documents = $this->student->documents ?? collect();
    }

    public function deleteDocument($docId)
    {
        $doc = StudentDocument::find($docId);
        if (!$doc) {
            session()->flash('error', 'Document introuvable.');
            return;
        }

        if ($doc->path && Storage::disk('public')->exists($doc->path)) {
            Storage::disk('public')->delete($doc->path);
        }

        $doc->delete();
        $this->loadStudent();

        session()->flash('message', 'Document supprimé.');
    }

    public function render()
    {
        return view('livewire.admin.student-wizard');
    }
}
