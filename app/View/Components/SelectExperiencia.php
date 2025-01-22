<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Experiencia;

class SelectExperiencia extends Component
{
    public $listado;
    public $selectTipo;
    public $name;

    public function __construct($selectTipo, $name = 'idexperiencia')
    {
        $this->selectTipo = $selectTipo;
        $this->listado = Experiencia::orderBy('idexperiencia')->get();
        $this->name = $name;
    }

    public function render()
    {
        return view('components.layouts.select-experiencia');
    }
}