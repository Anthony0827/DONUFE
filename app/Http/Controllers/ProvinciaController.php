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
use App\Models\Localidad;
use App\Models\Provincia;

class ProvinciaController extends Controller
{
    /**
     * Obtener localidades por provincia.
     */
    public function getLocalidades($idprovincia)
    {
        $localidades = Localidad::where('idprovincia', $idprovincia)->get();
        return response()->json($localidades);
    }
}