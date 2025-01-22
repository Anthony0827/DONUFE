<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Educacion;

class SelectEducacion extends Component
{
    public $listado;
    public $selectTipo;
    public $name;

    public function __construct($selectTipo, $name = 'ideducacion')
    {
        $this->selectTipo = $selectTipo;
        $this->listado = Educacion::orderBy('ideducacion')->get();
        $this->name = $name;
    }

    public function render()
    {
        return view('components.layouts.select-educacion');
    }
}