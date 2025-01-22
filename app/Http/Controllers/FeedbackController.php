<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\RespuestaOrdenada;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'motivo' => 'required|string',
            'comentario' => 'required|string|max:1000',
        ]);

        try {
            $idCandidato = Auth::user()->idcandidato; // Obtener el idcandidato del usuario autenticado

            Feedback::create([
                'motivo' => $request->motivo,
                'comentario' => $request->comentario,
                'idcandidato' => $idCandidato, // Guardar idcandidato junto con el feedback
            ]);

            // Retornar una respuesta JSON
            return response()->json(['success' => true, 'message' => '¡Feedback enviado con éxito!']);
        } catch (\Exception $e) {
            // Registrar el error en el log y retornar un error 500 en JSON
            Log::error('Error al guardar feedback: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Hubo un error al enviar el feedback.'], 500);
        }
    }

    public function vista()
    {
        $idCandidato = Auth::user()->idcandidato; // Obtener idcandidato autenticado
        return view('candidatos.feedback', compact('idCandidato')); // Pasar idcandidato a la vista
    }
}
