<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $label;
    public $type;

    /**
     * Create a new component instance.
     */
    public function __construct($label = null, $type = 'text')
{
    $this->label = $label;
    $this->type = $type;
}


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
