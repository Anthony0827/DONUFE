<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Feedback;

class SelectMotivo extends Component
{
    public $listado;       // Listado de motivos
    public $selectedMotivo; // Motivo seleccionado por defecto
    public $name;          // Nombre del campo en el formulario

    public function __construct($selectedMotivo = null, $name = 'motivo')
    {
        $this->selectedMotivo = $selectedMotivo;
        // Obtener los valores únicos de motivo desde la base de datos
        $this->listado = Feedback::select('motivo')->distinct()->get();
        $this->name = $name;
    }

    public function render()
    {
        return view('components.layouts.select-motivo');
    }
}
