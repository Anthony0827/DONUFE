<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class GoogleController extends Controller
{
     public function login()
     {
         return Socialite::driver('google')->redirect();
     }
  
     public function callback()
     {
         try {
 
             $usuarioGoogle = Socialite::driver('google')->stateless()->user();

             //dd($usuarioGoogle);

             //dd($usuarioGoogle->id);

             $existeUsuario = Usuario::where('google_id', $usuarioGoogle->id)->first();
 
             if($existeUsuario)
             {       
                 // Login inicia sesion sin comprobar usuario y contraseña, simplemente comprueba que el usuario existe en la base de datos
                 // Attempt inicia sesion si el usuario y la contraseña (sin cifrar) corresponden a algún usuario de la base de datos.
                 Auth::login($existeUsuario);
                 return redirect()->route('citas.index');
             }
             else
             {                
                $datos = array();
                $datos['username'] = $usuarioGoogle->email;
                $datos['google_id'] = $usuarioGoogle->id;
                $datos['password'] = Hash::make('1234');
                        
                $nuevoUsuario = Usuario::create($datos);

                /*
                 
                Auth::login($nuevoUsuario);
 
                */

                return redirect()->route('usuarios.login')->withErrors([
                    'google' => 'El usuario de Google no existe en la base de datos pero te hemos registrado, intenta loguearte de nuevo',
                ]);

             }         
 
         } 
         catch (Exception $e) 
         {
            return redirect()->route('usuarios.login')->withErrors([
                'google' => $e->getMessage()
            ]);
         }
 
     }
}