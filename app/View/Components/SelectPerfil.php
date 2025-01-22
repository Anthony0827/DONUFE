<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Perfil;

class SelectPerfil extends Component
{
    public $listado;
    public $selectTipo;
    public $name;

    public function __construct($selectTipo, $name = 'idperfil')
    {
        $this->selectTipo = $selectTipo;
        $this->listado = Perfil::orderBy('idperfil')->get();
        $this->name = $name;
    }

    public function render()
    {
        return view('components.layouts.select-perfil');
    }
}