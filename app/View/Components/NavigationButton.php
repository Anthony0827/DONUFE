<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavigationButton extends Component
{
    public $route;
    public $text;
    public $direction;

    public function __construct($route, $text, $direction)
    {
        $this->route = $route;
        $this->text = $text;
        $this->direction = $direction;
    }

    public function render()
    {
        return view('components.navigation-button');
    }
}
