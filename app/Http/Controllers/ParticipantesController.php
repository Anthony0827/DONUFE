<?php
namespace App\Http\Controllers;

use App\Models\Candidato;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Departamento;  // Asegúrate de que el modelo Departamento está importado
use Illuminate\Support\Facades\Log; // Importar la clase Log
use Illuminate\Support\Facades\Auth; // Importar la clase Auth

class ParticipantesController extends Controller
{
public function getData(Request $request)
{
    $idempresa = Auth::user()->idempresa; // Obtener el idempresa del usuario autenticado

    $query = Candidato::where('idempresa', $idempresa); // Filtrar por idempresa

    if ($request->has('departamento') && $request->departamento != '') {
        $query->whereHas('departamento', function ($q) use ($request) {
            $q->where('departamento', $request->departamento);
        });
    }

    return DataTables::of($query)
        ->addColumn('departamento', function ($participante) {
            // Retornar el nombre del departamento si existe
            return $participante->departamento ? $participante->departamento->departamento : 'N/A';
        })
        ->addColumn('action', function ($row) {
            return '<input type="checkbox" class="row-checkbox" data-id="' . $row->id . '">';
        })
        ->make(true);
}

public function listDepartments()
{
    $idempresa = Auth::user()->idempresa; // Obtener el idempresa del usuario autenticado
    $departments = Candidato::where('idempresa', $idempresa)
        ->with('departamento') // Cargar la relación con el modelo Departamento
        ->get()
        ->pluck('departamento.departamento') // Obtener el nombre del departamento
        ->unique()
        ->filter()
        ->values();

    return response()->json($departments);
}

}
