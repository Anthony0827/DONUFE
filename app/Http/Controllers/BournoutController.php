<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\RespuestaOrdenada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BournoutController extends Controller
{
    public function showbournout($encuestaId, $preguntaNumero = null)
    {
        // Asegúrate de que el ID de la encuesta es 4
        if ($encuestaId != 4) {
            return abort(404, 'Encuesta no encontrada.');
        }

        // Si $preguntaNumero es nulo, inicia en la primera pregunta
        $preguntaNumero = $preguntaNumero ?? 1;

        // Cargar la encuesta
        $encuesta = Encuesta::findOrFail($encuestaId);

        // Filtrar preguntas entre el rango de IDs 36 y 41
        $pregunta = Pregunta::where('encuesta_id', $encuestaId)
                    ->whereBetween('id', [36, 41])
                    ->skip($preguntaNumero - 1)
                    ->firstOrFail();

        // Obtener respuestas de la pregunta actual
        $respuestas = Respuesta::where('pregunta_id', $pregunta->id)->get();

        // Contar el total de preguntas en el rango para la navegación
        $totalPreguntas = Pregunta::where('encuesta_id', $encuestaId)
                                  ->whereBetween('id', [36, 41])
                                  ->count();

        // Obtener el idCandidato del usuario autenticado
        $idCandidato = Auth::user()->idcandidato;

        // Retornar la vista con los datos necesarios
        return view('encuestas.showbournout', compact('encuesta', 'pregunta', 'respuestas', 'preguntaNumero', 'totalPreguntas', 'idCandidato'));
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

    public function finalizarBournout($preguntaId, $idCandidato)
    {
        try {
            // Obtener el candidato autenticado
            $candidato = Auth::user();

            // Marcar bournout_completado como 1
            $candidato->bournout_completado = 1;

            // Marcar test_completado como 1
            $candidato->test_completado = 1;

            // Guardar los cambios en la base de datos
            $candidato->save();

            // Redirigir a la vista de edición del candidato
            return redirect()->route('candidatos.edit', ['idcandidato' => $idCandidato]);
        } catch (\Exception $e) {
            Log::error('Error al finalizar la encuesta: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al finalizar la encuesta.');
        }
    }

    public function showfeedback()
    {
        $idCandidato = Auth::user()->idcandidato; // Obtener idcandidato autenticado
        return view('candidatos.edit', compact('idCandidato')); // Pasar idcandidato a la vista
    }

}
