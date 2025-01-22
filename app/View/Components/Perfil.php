<?php

namespace App\View\Components;

use App\Models\Usuario;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Perfil extends Component
{
    public $nombre;
    public $log;
    
    public function __construct()
    {
        if (Auth::check())
        {
            $this->log = true;
            $usuario = Usuario::find(Auth::id(), ['idcandidato', 'email']);
            
            if ($usuario) {
                $this->nombre = $usuario->email;
            } else {
                $this->nombre = 'Usuario no encontrado';
            }
        }
        else
        {
            $this->log = false;
            $this->nombre = 'Invitado';
        }
    }

    public function render()
    {
        return view('components.perfil');
    }
}
