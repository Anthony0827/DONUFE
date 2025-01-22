<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\RespuestaOrdenada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EncuestaController extends Controller
{
    public function show($encuestaId, $preguntaNumero = 1)
    {
        $encuesta = Encuesta::findOrFail($encuestaId);
        $pregunta = Pregunta::where('encuesta_id', $encuestaId)->skip($preguntaNumero - 1)->firstOrFail();
        $respuestas = Respuesta::where('pregunta_id', $pregunta->id)->get();
        $totalPreguntas = Pregunta::where('encuesta_id', $encuestaId)->count();

        return view('encuestas.show', compact('encuesta', 'pregunta', 'respuestas', 'preguntaNumero', 'totalPreguntas'));
    }

    public function guardarOrden(Request $request, $preguntaId)
    {
        $ordenRespuestas = $request->input('orden');
        $respuestaSeleccionada = $request->input('respuestaSeleccionada');
        $idCandidato = Auth::user()->idcandidato; // Obtener el idcandidato del usuario autenticado
 Log::info('Datos recibidos:', [
        'orden' => $ordenRespuestas,
        'respuestaSeleccionada' => $respuestaSeleccionada,
        'idCandidato' => $idCandidato,
    ]);
        // Manejo de respuestas ordenables
        if (is_array($ordenRespuestas) && !empty($ordenRespuestas)) {
            foreach ($ordenRespuestas as $orden => $respuestaId) {
                $preguntaIdDeRespuesta = Respuesta::find($respuestaId)->pregunta_id ?? null;

                if ($preguntaIdDeRespuesta && $preguntaIdDeRespuesta == $preguntaId) {
                    RespuestaOrdenada::updateOrCreate(
                        ['pregunta_id' => $preguntaId, 'respuesta_id' => $respuestaId, 'idcandidato' => $idCandidato],
                        ['orden' => $orden + 1]
                    );
                } else {
                    return response()->json(['success' => false, 'message' => 'ID de respuesta o pregunta no válido.'], 400);
                }
            }

            return response()->json(['success' => true, 'message' => 'Orden de respuestas guardado exitosamente.']);
        }

        // Manejo de respuestas directas
        if ($respuestaSeleccionada) {
            $respuesta = Respuesta::where('pregunta_id', $preguntaId)
                                  ->where('respuesta_texto', $respuestaSeleccionada)
                                  ->first();

            if ($respuesta) {
                RespuestaOrdenada::updateOrCreate(
                    ['pregunta_id' => $preguntaId, 'respuesta_id' => $respuesta->id, 'idcandidato' => $idCandidato],
                    ['orden' => 1] // Fija el valor de orden en 1 para respuestas directas
                );

                return response()->json(['success' => true, 'message' => 'Respuesta seleccionada guardada exitosamente.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Respuesta seleccionada no válida.'], 400);
            }
        }

        return response()->json(['success' => false, 'message' => 'Datos de entrada inválidos.'], 400);
    }

    public function guardarRespuestaDirecta(Request $request, $preguntaId)
    {
        Log::info("Entrando en guardarRespuestaDirecta para preguntaId: {$preguntaId}");
        Log::info("Datos recibidos:", $request->all());

        $respuestaSeleccionada = $request->input('respuestaSeleccionada');
        $idCandidato = Auth::user()->idcandidato; // Obtener el idcandidato del usuario autenticado
 Log::info('Datos recibidos en guardarRespuestaDirecta:', [
        'respuestaSeleccionada' => $respuestaSeleccionada,
        'idCandidato' => $idCandidato,
    ]);
        if ($respuestaSeleccionada) {
            $respuesta = Respuesta::where('pregunta_id', $preguntaId)
                                  ->where('respuesta_texto', $respuestaSeleccionada)
                                  ->first();

            if ($respuesta) {
                RespuestaOrdenada::updateOrCreate(
                    ['pregunta_id' => $preguntaId, 'respuesta_id' => $respuesta->id, 'idcandidato' => $idCandidato],
                    ['orden' => 1] // Asigna un valor fijo para respuestas directas
                );

                Log::info("Respuesta seleccionada guardada exitosamente en la base de datos.");
                return response()->json(['success' => true, 'message' => 'Respuesta seleccionada guardada exitosamente.']);
            } else {
                Log::error("Respuesta seleccionada no válida para preguntaId: {$preguntaId}");
                return response()->json(['success' => false, 'message' => 'Respuesta seleccionada no válida.'], 400);
            }
        }

        Log::error("Datos de entrada inválidos: respuestaSeleccionada no proporcionada.");
        return response()->json(['success' => false, 'message' => 'Datos de entrada inválidos.'], 400);
    }

    public function finalizarEncuesta($preguntaId, $idCandidato)
    {
        try {
            // Obtener el candidato autenticado
            $candidato = Auth::user();

            // Marcar analisis_cultural_completado como 1
            $candidato->analisis_cultural_completado = 1;

            // Verificar si tanto bournout_completado, factores_sociales_completado, satisfaccion_laboral_completado como analisis_cultural_completado están completos
            if ($candidato->bournout_completado && $candidato->factores_sociales_completado && $candidato->satisfaccion_laboral_completado && $candidato->analisis_cultural_completado) {
                // Marcar test_completado como 1
                $candidato->test_completado = 1;
            }

            // Guardar los cambios en la base de datos
            $candidato->save();

            // Redirigir a la vista de satisfacción laboral
            return redirect()->route('encuesta.showsatisfaccion', ['encuestaId' => 2, 'preguntaNumero' => 1]);
        } catch (\Exception $e) {
            Log::error('Error al finalizar la encuesta: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al finalizar la encuesta.');
        }
    }

    public function showSatisfaccion($encuestaId, $preguntaNumero = 1)
    {
        return view('encuestas.showsatisfaccion', compact('encuestaId', 'preguntaNumero'));
    }
}
