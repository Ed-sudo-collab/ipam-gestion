<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DashboardCard extends Component
{
    public $title;
    public $value;
    public $icon;

    // On met des valeurs par défaut pour éviter les erreurs d'injection
    public function __construct($title = '', $value = '', $icon = '')
    {
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
    }

    /**
     * Récupère la vue du composant.
     */
    public function render(): View|string
    {
        return view('components.dashboard-card');
    }
}
