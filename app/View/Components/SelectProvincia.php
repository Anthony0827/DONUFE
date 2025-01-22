<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Provincia;

class SelectProvincia extends Component
{
    public $listado;
    public $selectTipo;
    public $name;

    public function __construct($selectTipo, $name = 'idprovincia')
    {
        $this->selectTipo = $selectTipo;
        $this->listado = Provincia::orderBy('idprovincia')->get();
        $this->name = $name;
    }

    public function render()
    {
        return view('components.layouts.select-provincia');
    }
}