<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Program;
use App\Models\Level;

class Programs extends Component
{
    use WithPagination;

    public $name, $description, $level_id, $program_id;
    public $search = '';
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:100|unique:programs,name',
        'level_id' => 'required|exists:levels,id',
        'description' => 'nullable|string',
    ];

    protected $paginationTheme = 'tailwind';

    /**
     * Rendu de la liste des programmes
     */
    public function render()
    {
        $programs = Program::where('name', 'like', '%'.$this->search.'%')
                           ->orderBy('id','desc')
                           ->paginate(10);

        $levels = Level::all();

        return view('livewire.admin.programs', compact('programs', 'levels'));
    }

    /**
     * Ouvrir le modal pour création ou édition
     */
    public function openModal($id = null)
    {
        $this->resetInputFields();

        if ($id) {
            $program = Program::find($id);
            if ($program) {
                $this->program_id = $program->id;
                $this->name = $program->name;
                $this->description = $program->description;
                $this->level_id = $program->level_id;
            } else {
                session()->flash('message', 'Programme introuvable.');
                return;
            }
        }

        $this->isModalOpen = true;
    }

    /**
     * Fermer le modal
     */
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    /**
     * Réinitialiser les champs du formulaire
     */
    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->level_id = '';
        $this->program_id = null;
    }

    /**
     * Créer ou mettre à jour un programme
     */
    public function saveProgram()
    {
        $rules = $this->rules;

        if ($this->program_id) {
            $rules['name'] = 'required|string|max:100|unique:programs,name,' . $this->program_id;
        }

        $this->validate($rules);

        Program::updateOrCreate(
            ['id' => $this->program_id],
            [
                'name' => $this->name,
                'description' => $this->description,
                'level_id' => $this->level_id,
            ]
        );

        session()->flash('message', $this->program_id ? 'Programme mis à jour.' : 'Programme créé avec succès.');

        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * Supprimer un programme
     */
    public function deleteProgram($id)
    {
        $program = Program::find($id);
        if ($program) {
            $program->delete();
            session()->flash('message', 'Programme supprimé.');
        } else {
            session()->flash('message', 'Programme introuvable.');
        }
    }
}
