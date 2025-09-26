<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Students extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    // Champs du formulaire rapide (modal)
    public $student_id;
    public $matricule, $nom, $prenom, $email, $telephone;

    public $isModalOpen = false;

    protected $rules = [
        'matricule' => 'required|string|max:50|unique:students,matricule',
        'nom'       => 'required|string|max:100',
        'prenom'    => 'required|string|max:100',
        'email'     => 'nullable|email|max:150|unique:students,email',
        'telephone' => 'nullable|string|max:20',
    ];

    // Mise à jour de la recherche
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::query()
            ->where('matricule', 'like', "%{$this->search}%")
            ->orWhere('nom', 'like', "%{$this->search}%")
            ->orWhere('prenom', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->orderBy('nom')
            ->paginate($this->perPage);

        return view('livewire.admin.students', compact('students'));
    }

    // Ouvrir modal création / édition
    public function openModal()
    {
        $this->resetValidation();
        $this->resetForm();

        // Génération automatique du matricule
        $this->matricule = $this->generateMatricule();

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->student_id = null;
        $this->matricule = '';
        $this->nom = '';
        $this->prenom = '';
        $this->email = '';
        $this->telephone = '';
    }

    // Génération automatique du matricule unique
    private function generateMatricule()
    {
        do {
            $matricule = 'S' . now()->format('Y') . rand(1000, 9999);
        } while (Student::where('matricule', $matricule)->exists());

        return $matricule;
    }

    // CRUD rapide étudiant + création utilisateur
    public function store()
    {
        $rules = $this->rules;

        if ($this->student_id) {
            $rules['matricule'] = 'required|string|max:50|unique:students,matricule,' . $this->student_id;
            $rules['email'] = 'nullable|email|max:150|unique:students,email,' . $this->student_id;
        }

        $this->validate($rules);

        // Création ou mise à jour de l'étudiant
        $student = Student::updateOrCreate(
            ['id' => $this->student_id],
            [
                'matricule' => $this->matricule,
                'nom'       => $this->nom,
                'prenom'    => $this->prenom,
                'email'     => $this->email,
                'telephone' => $this->telephone,
            ]
        );

        // Création automatique d’un compte utilisateur si nouvel étudiant
        if (!$this->student_id) {
            $userEmail = $this->email ?? strtolower($this->prenom . '.' . $this->nom) . '@example.com';

            User::create([
                'name' => $this->prenom . ' ' . $this->nom,
                'email' => $userEmail,
                'password' => Hash::make(Str::random(12)),
                'role' => 'student',
                'student_id' => $student->id,
                'telephone' => $this->telephone,
                'matricule' => $this->matricule,
            ]);
        }

        session()->flash(
            'message',
            $this->student_id ? 'Étudiant mis à jour avec succès ✅' : 'Étudiant et compte utilisateur créés avec succès 🎉'
        );

        $this->closeModal();
        $this->resetForm();
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        $this->student_id = $student->id;
        $this->matricule  = $student->matricule;
        $this->nom        = $student->nom;
        $this->prenom     = $student->prenom;
        $this->email      = $student->email;
        $this->telephone  = $student->telephone;

        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        Student::findOrFail($id)->delete();
        session()->flash('message', 'Étudiant supprimé avec succès 🗑️');
    }

    public function showDetails($id)
    {
        $this->emit('showStudent', $id);
    }
}
