<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\RespuestaOrdenada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SatisfaccionController extends Controller
{
    public function showsatisfaccion($encuestaId, $preguntaNumero = 1)
    {
        // Carga la encuesta con el ID proporcionado
        $encuesta = Encuesta::findOrFail($encuestaId);
        $pregunta = Pregunta::where('encuesta_id', $encuestaId)->skip($preguntaNumero - 1)->firstOrFail();

        // Obtener respuestas específicas
        $respuestas = Respuesta::where('pregunta_id', $pregunta->id)
                ->whereBetween('id', [15, 27])
                ->get();

        $totalPreguntas = Pregunta::where('encuesta_id', $encuestaId)->count();
        $idCandidato = Auth::user()->idcandidato; // Obtener el idcandidato del usuario autenticado

        return view('encuestas.showsatisfaccion', compact('encuesta', 'pregunta', 'respuestas', 'preguntaNumero', 'totalPreguntas', 'idCandidato'));
    }

    public function guardarRespuestaDirecta(Request $request, $preguntaId)
    {
        Log::info("Entrando en guardarRespuestaDirecta para preguntaId: {$preguntaId}");
        Log::info("Datos recibidos:", $request->all());

        $idCandidato = Auth::user()->idcandidato; // Obtener el idcandidato del usuario autenticado
        $respuestaSeleccionada = $request->input('respuestaSeleccionada', 0); 
        $feedback = $request->input('feedback', null);

        if ($respuestaSeleccionada) {
            $respuesta = Respuesta::where('pregunta_id', $preguntaId)
                                  ->where('respuesta_texto', $respuestaSeleccionada)
                                  ->first();

            if ($respuesta && $respuesta->id) {
                RespuestaOrdenada::updateOrCreate(
                    [
                        'pregunta_id' => $preguntaId,
                        'respuesta_id' => $respuesta->id,
                        'idcandidato' => $idCandidato, // Incluye idcandidato en las condiciones únicas
                    ],
                    [
                        'orden' => 0,
                        'valor' => $respuestaSeleccionada,
                        'feedback' => $feedback,
                    ]
                );

                Log::info("Respuesta guardada exitosamente con feedback: {$feedback}, idcandidato: {$idCandidato}");
                return response()->json(['success' => true, 'message' => 'Respuesta guardada exitosamente.']);
            } else {
                Log::error("Respuesta seleccionada no válida o respuesta_id no encontrado.");
                return response()->json(['success' => false, 'message' => 'Respuesta seleccionada no válida o respuesta_id no encontrado.'], 400);
            }
        }

        Log::error("Datos de entrada inválidos.");
        return response()->json(['success' => false, 'message' => 'Datos de entrada inválidos.'], 400);
    }

    public function finalizarSatisfaccion($preguntaId, $idCandidato)
    {
        try {
            // Obtener el candidato autenticado
            $candidato = Auth::user();

            // Marcar satisfaccion_laboral_completado como 1
            $candidato->satisfaccion_laboral_completado = 1;

            // Verificar si tanto bournout_completado, factores_sociales_completado como satisfaccion_laboral_completado están completos
            if ($candidato->bournout_completado && $candidato->factores_sociales_completado && $candidato->satisfaccion_laboral_completado) {
                // Marcar test_completado como 1
                $candidato->test_completado = 1;
            }

            // Guardar los cambios en la base de datos
            $candidato->save();

            // Redirigir a la vista de factores sociales
            return redirect()->route('encuesta.showfactoressociales', ['encuestaId' => 3, 'preguntaNumero' => 1]);
        } catch (\Exception $e) {
            Log::error('Error al finalizar la encuesta: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al finalizar la encuesta.');
        }
    }

    public function showFactoressociales($encuestaId, $preguntaNumero = 1)
    {
        $idCandidato = Auth::user()->idcandidato; // Obtener idcandidato autenticado
        return view('encuestas.showfactoressociales', compact('encuestaId', 'preguntaNumero', 'idCandidato'));
    }
}
