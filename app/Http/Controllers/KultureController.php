<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citas;
use App\Models\TipoLavado;
use Illuminate\Support\Str;
use App\Rules\TipoVacio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\DB;

class KultureController extends Controller
{
      public function index()
    {
        return view('candidatos.inicio');
    }


    public function home()
    {
        return view('candidatos.dashboard');
    }



       public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

       public function plantilla()
    {
        // Definir la variable $datos
        $datos = [
            'idrangoedad' => 1, // Cambia esto por el valor que necesites
            'nombres' => 'John',
            'apellidos' => 'Doe',
        ];

        // Definir la variable $option_rangoedad
        $option_rangoedad = [
            1 => 'Menos de 18 años',
            2 => 'Entre 18 y 25 años',
            3 => 'Entre 26 y 35 años',
            4 => 'Entre 36 y 45 años',
            5 => 'Entre 46 y 55 años',
            6 => 'Más de 55 años',
        ];

        // Pasar las variables a la vista
        return view('candidatos.plantilla_datos_adicionales', compact('datos', 'option_rangoedad'));
    }
}
