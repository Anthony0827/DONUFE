<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Localidad;

class SelectLocalidad extends Component
{
    public $listado;
    public $selectTipo;
    public $name;
    public $id;

    public function __construct($selectTipo, $name = 'idlocalidad', $idprovincia = null, $id = null)
    {
        \Log::info('ID Provincia recibido en el componente:', ['idprovincia' => $idprovincia]);

        $this->selectTipo = $selectTipo;
        $this->name = $name;
        $this->id = $id ?? $name;

        $this->listado = $idprovincia 
            ? Localidad::where('idprovincia', $idprovincia)->orderBy('localidad')->get() 
            : collect();

        \Log::info('Listado de localidades en el componente:', ['listado' => $this->listado]);
    }

    public function render()
    {
        return view('components.layouts.select-localidad');
    }
}
