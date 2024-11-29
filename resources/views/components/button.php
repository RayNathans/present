<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $class;
    public $onclick;

    public function __construct($type = 'button', $class = '', $onclick = '')
    {
        $this->type = $type;
        $this->class = $class;
        $this->onclick = $onclick;
    }

    public function render()
    {
        return view('components.button');
    }
}
