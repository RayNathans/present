<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    public $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function render(): View|Closure|string
    {
        return view('components.search');
    }
}
