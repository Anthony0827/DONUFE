<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\RangoEdad;

class SelectRangoEdad extends Component
{
    public $listado;
    public $selectTipo;
    public $name;

    public function __construct($selectTipo, $name = 'idrangoedad')
    {
        $this->selectTipo = $selectTipo;
        $this->listado = RangoEdad::orderBy('idrangoedad')->get();
        $this->name = $name;
    }

    public function render()
    {
        return view('components.layouts.select-rangoedad');
    }
}
