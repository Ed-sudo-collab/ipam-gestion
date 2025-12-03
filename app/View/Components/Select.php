<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $options;

    public function __construct($label, $options = [])
    {
        $this->label = $label;
        $this->options = $options;
    }

    public function render()
    {
        return view('components.select');
    }
}
