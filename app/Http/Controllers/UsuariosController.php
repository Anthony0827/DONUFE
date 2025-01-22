<?php
namespace App\Http\Controllers;

use App\Models\Candidato;  // Usar el modelo Candidato en lugar de Usuario
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMail;

class UsuariosController extends Controller
{
    public function registro()
    {
        return view('usuarios.registro');
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $datos = $request->validate([
            'email' => 'required|email|unique:candidatos,email', // La tabla correcta es 'candidatos'
            'clave' => 'required|min:8|confirmed',
            'nombres' => 'required|' // Validación de nombres
        ]);

        // Hash de la contraseña
        $datos['clave'] = Hash::make($datos['clave']);

        // Guardar el candidato en la base de datos
        Candidato::create([  // Usamos Candidato en lugar de Usuario
            'email' => $datos['email'],
            'clave' => $datos['clave'],
            'nombres' => $datos['nombres'],
            // Agregar otros campos que sean necesarios
        ]);

        return redirect()->route('usuarios.login')->with('success', 'Usuario registrado correctamente.');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('candidatos.dashboard');
        }

        return view('usuarios.login');
    }

   public function authenticate(Request $request)
{
    // Validación de los datos de entrada
    $datos = $request->validate([
        'email' => 'required|email',
        'clave' => 'required',
    ]);

    // Buscar al candidato con el email ingresado
    $user = Candidato::where('email', $datos['email'])->first();

    // Verificar si el usuario existe y si la contraseña proporcionada es correcta
    if ($user && Hash::check($datos['clave'], $user->clave)) {  // Usar Hash::check para comparar la contraseña
        Auth::guard('web')->login($user); // Iniciar sesión con el modelo Candidato
        $request->session()->regenerate();

        \Log::info('Usuario autenticado:', ['idcandidato' => $user->idcandidato]);
        return redirect()->route('candidatos.dashboard');
    }

    \Log::error('Error de autenticación: Credenciales inválidas', ['email' => $datos['email']]);
    return back()->withErrors(['clave' => 'El usuario y la contraseña no son correctos']);
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('usuarios.login');
    }

    public function showForgotPasswordForm()
    {
        return view('usuarios.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Buscar al candidato
        $user = Candidato::where('email', $request->email)->first(); // Buscar en la tabla candidatos

        if (!$user) {
            return back()->withErrors(['email' => 'No se encontró ningún usuario con este correo.']);
        }

        // Generar token y enviar el correo
        $token = Str::random(60);
        $user->update([
            'recuperacion_token' => $token,
            'recuperacion_validohasta' => Carbon::now()->addHour(),
        ]);

        Mail::to($user->email)->send(new PasswordResetMail($token));

        return back()->with('status', 'Se ha enviado un correo para recuperar tu contraseña.');
    }

    public function showResetPasswordForm($token)
    {
        $user = Candidato::where('recuperacion_token', $token)->first();  // Buscar en la tabla candidatos

        if (!$user) {
            return redirect()->route('usuarios.login')->withErrors(['token' => 'El token es inválido o ha expirado.']);
        }

        return view('usuarios.reset-password', [
            'token' => $token,
            'nombres' => $user->nombres  // Aquí asumimos que `nombres` es el campo del nombre del candidato
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        $user = Candidato::where('recuperacion_token', $request->token)
            ->where('recuperacion_validohasta', '>=', Carbon::now())
            ->first();  // Buscar en la tabla candidatos

        if (!$user) {
            return back()->withErrors(['token' => 'El token es inválido o ha expirado.']);
        }

        $user->update([
            'clave' => Hash::make($request->password),
            'recuperacion_token' => null,
            'recuperacion_validohasta' => null,
        ]);

        return redirect()->route('usuarios.login')->with('status', '¡Tu contraseña se ha actualizado correctamente!');
    }
}
