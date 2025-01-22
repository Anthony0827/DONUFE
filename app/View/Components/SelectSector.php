<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Sector;

class SelectSector extends Component
{
    public $listado;
    public $selectTipo;
    public $name;

    public function __construct($selectTipo, $name = 'idsector')
    {
        $this->selectTipo = $selectTipo;
        $this->listado = Sector::orderBy('idsector')->get();
        $this->name = $name;
    }

    public function render()
    {
        return view('components.layouts.select-sector');
    }
}