<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Limit extends Component
{
    public $route;
    public $limitOptions;

    public function __construct($route, $limitOptions = [5, 10, 25, 50])
    {
        $this->route = $route;
        $this->limitOptions = $limitOptions;
    }

    public function render(): View|Closure|string
    {
        return view('components.limit');
    }
}
