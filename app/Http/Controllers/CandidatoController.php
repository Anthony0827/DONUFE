<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use App\Models\Provincia;
use App\Models\Localidad;
use App\Models\Educacion;
use App\Models\Situacion;
use App\Models\Perfil;
use App\Models\Departamento;
use App\Models\Experiencia;
use App\Models\RangoEdad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Foundation\Auth\User as Authenticatable; // Asegúrate de extender 'Authenticatable'


class CandidatoController extends Controller
{
    // Muestra el formulario de edición
    public function edit($idcandidato)
    {

         if(Auth::check()==false) 
        {
            return redirect()->route('usuarios.login')->with('success', 'No tienes permiso, identifícate.');
        }
       
        // Encuentra el candidato por su ID (int)
      
        $candidatos = Candidato::findOrFail($idcandidato);
        // Consulta lo datos de provincias y rango de edad para los select
        $listadoProvincias = Provincia::all();
        $listadoRangoEdad = RangoEdad::all();
        $listadoDepartamentos = Departamento::all();
        $listadoEducacion = Educacion::all();
        $listadoExperiencia = Experiencia::all();
        $listadoPerfil = Perfil::all();
        $listadoSituacion = Situacion::all();
        $listadoLocalidad = Localidad::all();
      

        return view('candidatos.edit', compact('candidatos', 'listadoProvincias', 'listadoRangoEdad', 'listadoDepartamentos', 'listadoEducacion', 'listadoExperiencia', 'listadoPerfil', 'listadoSituacion','listadoLocalidad' ));
    }
public function update(Request $request, $idcandidato)
{

   
    $request->validate([
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'sexo' => 'required',
        'idrangoedad' => 'required|exists:candidatos_rango_edad,idrangoedad',
        'idprovincia' => 'required|exists:ubica_provincia,idprovincia',
        'ideducacion' => 'required|exists:candidatos_educacion,ideducacion',
        'idexperiencia' => 'required|exists:candidatos_experiencia,idexperiencia',
        'idperfil' => 'required|exists:candidatos_perfil,idperfil',



               //'idlocalidad' => 'required|exists:ubica_localidad,idlocalidad',
        //'iddepartamento' => 'required|exists:departamentos,iddepartamento',
                //'telefono' => 'required|string|max:15',
        //'idsituacion' => 'required|exists:candidatos_situacion_laboral,idsituacion',
        
        
        

    ]);

    // Encuentra el candidato y actualiza sus datos
    $candidato = Candidato::findOrFail($idcandidato);


if ($request->hasFile('archivocv')) {
    \Log::info('Archivo recibido:', ['archivo' => $request->file('archivocv')]);
    // Continúa con la lógica de almacenamiento del archivo...
}

if ($request->hasFile('archivocv')) {
    if ($candidato->archivocv) {
        Storage::delete('public/' . $candidato->archivocv);
    }
    $path = $request->file('archivocv')->store('archivocv', 'public');
    \Log::info('Archivo guardado en la ruta:', ['ruta' => $path]); // Registro para verificar la ruta de almacenamiento
    $candidato->archivocv = $path;
}

    // Asignación de valores
    $candidato->nombres = $request->input('nombres');
    $candidato->apellidos = $request->input('apellidos');

    // $candidato->telefono = $request->input('telefono'); 
    //$candidato->idlocalidad = $request->input('idlocalidad'); // Verifica que se asigna aquí
      //  $candidato->iddepartamento = $request->input('iddepartamento'); // Verifica que se asigna aquí
    // $candidato->idsituacion = $request->input('idsituacion'); // Verifica que se asigna aquí

    $candidato->sexo = $request->input('sexo');
    $candidato->idrangoedad = $request->input('idrangoedad'); // Verifica que se asigna aquí
    $candidato->idprovincia = $request->input('idprovincia'); // Verifica que se asigna aquí
    
    $candidato->ideducacion = $request->input('ideducacion'); // Verifica que se asigna aquí
    $candidato->idexperiencia = $request->input('idexperiencia'); // Verifica que se asigna aquí
    $candidato->idperfil = $request->input('idperfil'); // Verifica que se asigna aquí

  $candidato->archivocv = $request->input('archivocv'); // Verifica que se asigna aquí

  
    // Guarda los cambios en la base de datos
    $candidato->save();

  return redirect()->route('candidatos.dashboard', $idcandidato)->with('success', 'Datos actualizados correctamente.');

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
        return view('candidatos.home'); // Asegúrate de que esta vista exista en la carpeta resources/views/candidatos
    }

    // Método para la vista "Instrucciones"
  





   
}
