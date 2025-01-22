<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productividad;
use App\Models\Localidad;
use App\Models\Provincia;
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

class ProductividadController extends Controller



{

public function store(Request $request)
{
    try {
        Log::info('Iniciando el método store en ProductividadController.');

        // Obtener idcandidato desde el usuario autenticado
        $idcandidato = Auth::user()->idcandidato;
        Log::info("ID del candidato autenticado: {$idcandidato}");

        // Validar los demás datos sin incluir idcandidato
        $data = $request->validate([
            'tipoRegistro' => 'required|string',
            'tipoFlujo' => 'required|string',
            'titulo' => 'required|string',
            'texto' => 'required|string',
            'prioridad' => 'required|in:ALTA,MEDIA,BAJA', // Validar prioridad
        ]);

        Log::info('Datos validados correctamente:', $data);

        // Crear el registro en la base de datos
        Productividad::create([
            'idcandidato' => $idcandidato,
            'registro' => $data['tipoRegistro'],
            'flujo' => $data['tipoFlujo'],
            'titulo' => $data['titulo'],
            'mensaje' => $data['texto'],
            'fechabacklog' => now(),
            'prioridad' => $data['prioridad'], // Guardar prioridad
        ]);

        Log::info('Registro creado exitosamente en la base de datos.');

        // Respuesta de éxito
        return response()->json(['status' => 'CREADO']);
    } catch (\Exception $e) {
        Log::error('Error en ProductividadController@store: ' . $e->getMessage());

        // Captura el error y devuelve en JSON
        return response()->json([
            'status' => 'ERROR',
            'message' => $e->getMessage()
        ], 500);
    }
}



public function mover(Request $request)
{
    try {
        $idcandidato = Auth::user()->idcandidato;

        // Valida los datos del Request
        $validated = $request->validate([
            'id' => 'required|string|uuid', // Validar que 'id' sea UUID
            'flujo' => 'required|string', // Validar que 'flujo' sea string
        ]);

        $productividad = Productividad::where('id', $validated['id'])
            ->where('idcandidato', $idcandidato)
            ->firstOrFail();

        // Actualiza el flujo
        $productividad->flujo = $validated['flujo'];

        // Actualiza la fecha del flujo correspondiente
        switch ($validated['flujo']) {
            case 'PLANIFICADA':
                $productividad->fechaplanificada = now();
                break;
            case 'EN_PROGRESO':
                $productividad->fechaprogreso = now();
                break;
            case 'BLOQUEO':
                $productividad->fechabloqueo = now();
                break;
            case 'TERMINADA':
                $productividad->fechaterminada = now();
                break;
        }
        $productividad->save();

        return response()->json(['status' => 'ACTUALIZADO']);
    } catch (\Exception $e) {
        Log::error('Error en ProductividadController@mover: ' . $e->getMessage());
        return response()->json(['status' => 'ERROR', 'message' => $e->getMessage()], 500);
    }
}


public function getDatos($tipo, Request $request)
{
    try {
        // Obtener idcandidato desde el usuario autenticado
        $idcandidato = Auth::user()->idcandidato;
        Log::info("Obteniendo datos de productividad para el candidato ID: {$idcandidato} y tipo: {$tipo}");

        // Realiza la consulta en base al tipo y al idcandidato
        $query = Productividad::where('idcandidato', $idcandidato);
        
        if ($tipo !== 'TODOS') {
            $query->where('flujo', $tipo);
        }

        $datos = $query->get();
        Log::info("Datos obtenidos: " . $datos->toJson());

        // Devuelve los datos como respuesta JSON
        return response()->json($datos);
    } catch (\Exception $e) {
        Log::error('Error en ProductividadController@getDatos: ' . $e->getMessage());
        return response()->json(['error' => 'Error al obtener los datos'], 500);
    }
}
}