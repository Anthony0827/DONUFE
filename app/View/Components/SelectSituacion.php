<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Situacion;

class SelectSituacion extends Component
{
    public $listado;
    public $selectTipo;
    public $name;

    public function __construct($selectTipo, $name = 'idsituacion')
    {
        $this->selectTipo = $selectTipo;
        $this->listado = Situacion::orderBy('idsituacion')->get();
        $this->name = $name;
    }

    public function render()
    {
        return view('components.layouts.select-situacion');
    }
}