<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productividad;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\RespuestaOrdenada;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;




class TableroController extends Controller
{
public function index(Request $request)
{
    $idcandidato = Auth::user()->idcandidato;

    // Obtener las tareas agrupadas por flujo
    $datos = Productividad::where('idcandidato', $idcandidato)
        ->get()
        ->groupBy('flujo');

    return view('tablero', compact('datos'));
}



}

