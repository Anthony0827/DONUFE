<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Departamento;

class SelectDepartamento extends Component
{
    public $listado;
    public $selectTipo;
    public $name;

    public function __construct($selectTipo, $name = 'iddepartamento')
    {
        $this->selectTipo = $selectTipo;
        $this->listado = Departamento::orderBy('iddepartamento')->get();
        $this->name = $name;
    }

    public function render()
    {
        return view('components.layouts.select-departamento');
    }
}