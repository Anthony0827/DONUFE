<?php

namespace App\Http\Controllers;

use App\Models\Emp_Usuarios;
use App\Models\Empresas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMailEmp;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Emp_UsuariosController extends Controller
{
    public function create()
    {
        return view('empresas.registro');
    }


    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('empresas.dashboard');
        }
        return view('empresas.login');
    }

public function authenticate(Request $request)
{
    $datos = $request->validate([
        'email' => 'required|email',
        'clave' => 'required',
    ]);

    $user = Emp_Usuarios::where('email', $datos['email'])->first();

    if ($user && Hash::check($datos['clave'], $user->clave)) {
Auth::guard('emp_usuarios')->login($user);
        $request->session()->regenerate();

        \Log::info('Usuario autenticado:', ['idusuario' => $user->idusuario]);
        return redirect()->route('empresas.dashboard');
    }

    \Log::error('Error de autenticación: Credenciales inválidas', ['email' => $datos['email']]);
    return back()->withErrors(['clave' => 'El usuario y la contraseña no son correctos']);
}




    /** ====================
     * Registro de Usuarios
     * ==================== */
public function store(Request $request)
{
    DB::beginTransaction(); // Inicia la transacción
    \Log::info('Datos enviados para registro:', $request->all());

    try {
        // Validación de datos
        $datos = $request->validate([
            'nombreEmpresa' => 'required|string|max:200',
            'telefono' => 'required|string|max:15',
            'cif' => 'required|string|max:20|unique:empresas,cif',
            'tipoEmpresa' => 'required|integer|in:1,2,3,4',
            'emailRegistro' => 'required|email|max:150|unique:emp_usuarios,email',
            'emailConfirmar' => 'required|same:emailRegistro',
            'claveRegistro' => 'required|min:8|confirmed',
            'condicionesContratacion' => 'accepted',
            'politicaEmails' => 'accepted',
        ]);

        // Crear el usuario
        $usuario = Emp_Usuarios::create([
            'username' => $datos['nombreEmpresa'],
            'email' => $datos['emailRegistro'],
            'clave' => Hash::make($datos['claveRegistro']),
            'telefono' => $datos['telefono'],
            'idempresa' => null, // Temporalmente null
        ]);

        \Log::info('Usuario creado:', ['idusuario' => $usuario->idusuario]);

        // Crear la empresa y asignar idempresa manualmente
        $empresa = new Empresas([
            'idempresa' => $usuario->idusuario,
            'nombreEmpresa' => $datos['nombreEmpresa'],
            'telefono' => $datos['telefono'],
            'cif' => $datos['cif'],
            'tipoEmpresa' => $datos['tipoEmpresa'],
        ]);

        $empresa->save();

        // Refrescar el modelo empresa
        $empresa = Empresas::find($usuario->idusuario);

        \Log::info('Empresa creada:', ['idempresa' => $empresa->idempresa]);

        // Actualizar idempresa en el usuario
        $usuario->update(['idempresa' => $empresa->idempresa]);

        \Log::info('Usuario actualizado con idempresa:', ['idempresa' => $usuario->idempresa]);

        // Enviar correo al usuario registrado
      $emailData = [
    'nombreEmpresa' => $datos['nombreEmpresa'],
    'telefono' => $datos['telefono'],
    'cif' => $datos['cif'],
    'email' => $datos['emailRegistro'], // Nota: aquí usamos 'email', no 'emailRegistro'
    'tipoEmpresa' => $this->getTipoEmpresaLabel($datos['tipoEmpresa']),
];

\Log::info('Datos para el correo:', $emailData);



        Mail::to($datos['emailRegistro'])->send(new \App\Mail\RegistroEmpresaMail($emailData));

        \Log::info('Correo enviado a:', ['email' => $datos['emailRegistro']]);

        DB::commit(); // Confirmar la transacción
        \Log::info('Registro exitoso:', ['idusuario' => $usuario->idusuario, 'idempresa' => $empresa->idempresa]);

        return redirect()->route('empresas.login')->with('success', 'Empresa y usuario registrados correctamente.');
    } catch (\Exception $e) {
        DB::rollBack(); // Revertir los cambios si hay error
        \Log::error('Error durante el registro: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Error durante el registro. Por favor, inténtalo de nuevo.']);
    }
}

/**
 * Transforma el ID del tipo de empresa en una descripción.
 */
private function getTipoEmpresaLabel($tipoEmpresa)
{
    $labels = [
        1 => 'Inicial (1 - 10 empleados)',
        2 => 'Startup (11 - 50 empleados)',
        3 => 'Media (51 - 150 empleados)',
        4 => 'Grande (más de 150 empleados)',
    ];

    return $labels[$tipoEmpresa] ?? 'Desconocido';
}


  public function logout(Request $request)
{
    Auth::logout(); // Cerrar la sesión del usuario

    $request->session()->invalidate(); // Invalida la sesión
    $request->session()->regenerateToken(); // Regenera el token CSRF

    return redirect()->route('empresas.login')->with('success', 'Sesión cerrada correctamente.');
}

       public function showForgotPasswordFormEmp()
    {
        return view('empresas.forgot-passwordemp');
    }

     public function sendResetLinkEmp(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Buscar en el modelo de Emp_Usuarios
    $user = Emp_Usuarios::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No se encontró ningún usuario con este correo.']);
    }

    // Generar token y enviar el correo
    $token = Str::random(60);
    $user->update([
        'recuperacion_token' => $token,
        'recuperacion_validohasta' => Carbon::now()->addHour(),
    ]);

    Mail::to($user->email)->send(new PasswordResetMailEmp($token));

    return back()->with('status', 'Se ha enviado un correo para recuperar tu contraseña.');
}

public function showResetPasswordFormEmp($token)
{
    $user = Emp_Usuarios::where('recuperacion_token', $token)->first();

    if (!$user) {
        return redirect()->route('empresas.login')->withErrors(['token' => 'El token es inválido o ha expirado.']);
    }

    // Pasamos la variable $nombres a la vista
    // Pasamos el nombre del usuario y el token a la vista
    return view('empresas.reset-passwordemp', [
        'token' => $token,
        'nombres' => $user // Aquí asumimos que `name` es el campo del nombre del usuario
    ]);
}
    public function resetPasswordEmp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        $user = Emp_Usuarios::where('recuperacion_token', $request->token)
            ->where('recuperacion_validohasta', '>=', Carbon::now())
            ->first();

        if (!$user) {
            return back()->withErrors(['token' => 'El token es inválido o ha expirado.']);
        }

        $user->update([
            'clave' => Hash::make($request->password),
            'recuperacion_token' => null,
            'recuperacion_validohasta' => null,
        ]);

        return redirect()->route('empresas.login')->with('status', '¡Tu contraseña se ha actualizado correctamente!');
    }

    public function getAuthPassword()
{
    return $this->clave;
}




}

