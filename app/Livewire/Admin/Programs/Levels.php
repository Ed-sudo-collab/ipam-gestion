<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Level;

class Levels extends Component
{
    use WithPagination;

    public $name;
    public $level_id;
    public $search = '';
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:50|unique:levels,name',
    ];

    protected $paginationTheme = 'tailwind';

    /**
     * Rendu de la liste des niveaux
     */
    public function render()
    {
        $levels = Level::where('name', 'like', '%'.$this->search.'%')
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return view('livewire.admin.levels', compact('levels'));
    }

    /**
     * Ouvrir le modal pour création ou édition
     */
    public function openModal($id = null)
    {
        $this->resetInputFields();

        if ($id) {
            $level = Level::find($id);
            if ($level) {
                $this->level_id = $level->id;
                $this->name = $level->name;
            } else {
                session()->flash('message', 'Niveau introuvable.');
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
        $this->level_id = null;
    }

    /**
     * Créer ou mettre à jour un niveau
     */
    public function saveLevel()
    {
        $rules = $this->rules;

        if ($this->level_id) {
            $rules['name'] = 'required|string|max:50|unique:levels,name,' . $this->level_id;
        }

        $this->validate($rules);

        Level::updateOrCreate(
            ['id' => $this->level_id],
            ['name' => $this->name]
        );

        session()->flash('message', $this->level_id ? 'Niveau mis à jour avec succès.' : 'Niveau créé avec succès.');

        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * Supprimer un niveau
     */
    public function deleteLevel($id)
    {
        $level = Level::find($id);
        if ($level) {
            $level->delete();
            session()->flash('message', 'Niveau supprimé avec succès.');
        } else {
            session()->flash('message', 'Niveau introuvable.');
        }
    }
}
