<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emp_Usuarios;
use App\Models\Empresas;
use App\Models\Provincia;
use App\Models\Localidad;
use App\Models\Sector;
use App\Models\Departamento;
use App\Models\Candidatos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class EmpresasController extends Controller
{
    public function edit($idempresa)
    {
        if (!Auth::check()) {
            \Log::info('Usuario no autenticado.');
            return redirect()->route('empresas.login')->with('error', 'Debes iniciar sesión.');
        }

        // Verifica si el usuario tiene permisos para la empresa
        $usuario = Auth::user();
        if ($usuario->idempresa != $idempresa) {
            \Log::warning('Intento de acceso no autorizado.', [
                'idusuario' => $usuario->idusuario,
                'idempresa_intentada' => $idempresa,
            ]);
            abort(403, 'No tienes permiso para acceder a esta empresa.');
        }

        \Log::info('Usuario autenticado y autorizado.', ['idusuario' => $usuario->idusuario]);

        // Obtiene la empresa
        $empresa = Empresas::with('usuario')->find($idempresa);

        if (!$empresa) {
            \Log::error('Empresa no encontrada.', ['idempresa' => $idempresa]);
            abort(404, 'Empresa no encontrada.');
        }

        \Log::info('Empresa cargada:', ['empresa' => $empresa]);

        // Listado de provincias
        $listadoProvincias = Provincia::all();
        \Log::info('Listado de Provincias:', ['provincias' => $listadoProvincias]);

        // Listado de sectores
        $listadoSector = Sector::all();

        // Localidades (si la empresa tiene una provincia asignada)
        $listadoLocalidad = collect();
        if (!is_null($empresa->idprovincia)) {
            $listadoLocalidad = Localidad::where('idprovincia', $empresa->idprovincia)->get();
            \Log::info('SQL generada:', [
                'query' => Localidad::where('idprovincia', $empresa->idprovincia)->toSql(),
                'bindings' => Localidad::where('idprovincia', $empresa->idprovincia)->getBindings(),
                'localidades' => $listadoLocalidad,
            ]);

            if ($listadoLocalidad->isEmpty()) {
                \Log::warning('No se encontraron localidades para la provincia.', ['idprovincia' => $empresa->idprovincia]);
            }
        }

        return view('empresas.datos', [
            'empresa' => $empresa,
            'email' => $empresa->usuario->email ?? '',
            'listadoProvincias' => $listadoProvincias,
            'listadoSector' => $listadoSector,
            'listadoLocalidad' => $listadoLocalidad,
        ]);
    }





public function update(Request $request, $idempresa)
{

   
    $request->validate([
        'telefono' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'idsector' => 'required|exists:sector,idsector',
        'idprovincia' => 'required|exists:ubica_provincia,idprovincia',
        //'iddepartamento' => 'required|exists:departamentos,iddepartamento',
                //'telefono' => 'required|string|max:15',
        //'idsituacion' => 'required|exists:candidatos_situacion_laboral,idsituacion',
    ]);

    // Encuentra el candidato y actualiza sus datos
$empresa = Empresas::findOrFail($idempresa);


    // Asignación de valores
    $empresa->telefono = $request->input('telefono');
    $empresa->direccion = $request->input('direccion');
    $empresa->idsector = $request->input('idsector');
    $empresa->idlocalidad = $request->input('idlocalidad'); // Verifica que se asigna aquí
      //  $candidato->iddepartamento = $request->input('iddepartamento'); // Verifica que se asigna aquí
    // $candidato->idsituacion = $request->input('idsituacion'); // Verifica que se asigna aquí
    $empresa->idprovincia = $request->input('idprovincia'); // Verifica que se asigna aquí
    
    // Guarda los cambios en la base de datos
    $empresa->save();

  return redirect()->route('empresas.dashboard', $idempresa)->with('success', 'Datos actualizados correctamente.');

}
// public function getLocalidades($idprovincia)
//{
    // Filtra las localidades por idprovincia
   // $localidades = Localidad::where('idprovincia', $idprovincia)->orderBy('localidad')->get();

    // Devuelve las localidades como respuesta JSON
//    return response()->json($localidades);
//}


   // Método para la vista "Home"
    public function homee()
    {
        return view('empresas.home'); // Asegúrate de que esta vista exista en la carpeta resources/views/candidatos
    }

    // Método para la vista "Instrucciones"
  
public function info() {
    return view('empresas.home');
}

public function datos() {
    return view('empresas.datos');
}
public function importar() {
    return view('empresas.importar');
}
public function panel() {
    return view('empresas.panel');
}

public function configuracion() {
    return view('empresas.configuracion');
}
   
}
