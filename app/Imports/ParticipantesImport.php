<?php

namespace App\Imports;

use App\Models\Candidato;
use App\Models\Departamento;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPasswordMail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ParticipantesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            // Validar datos esenciales
            if (empty($row['nombre']) || empty($row['apellidos']) || empty($row['email']) || empty($row['departamento'])) {
                Log::warning('Faltan datos en la fila:', $row);
                return null;
            }

            // Buscar el iddepartamento correspondiente al nombre del departamento
            $departamento = Departamento::where('departamento', $row['departamento'])->first();
            if (!$departamento) {
                // Crear un nuevo departamento si no existe
                $departamento = new Departamento();
                $departamento->departamento = $row['departamento'];
                $departamento->save();
                Log::info("El departamento '{$row['departamento']}' ha sido creado.");
            }

            // Generar una contraseña aleatoria
            $password = Str::random(12); // Contraseña más fuerte (12 caracteres)

            // Obtener el idempresa de la empresa que ha iniciado sesión
            $idempresa = Auth::user()->idempresa;

            // Crear un nuevo candidato
            $candidato = new Candidato();
            $candidato->fill([
                'nombres' => $row['nombre'],
                'apellidos' => $row['apellidos'],
                'email' => $row['email'],
                'iddepartamento' => $departamento->iddepartamento, // Asignar el ID del departamento
                'idempresa' => $idempresa, // Asignar el ID de la empresa
                'clave' => Hash::make($password), // Asignar el campo 'clave'
                'situacionregistro' => 1, // Valor predeterminado para situacionregistro
                'invitacion_enviada' => true, // Marcar la invitación como enviada
            ]);
            $candidato->save();  // La base de datos asignará automáticamente el idcandidato

            // Enviar correo con la contraseña generada
            Mail::to($candidato->email)->send(new SendPasswordMail($candidato, $password));

            return $candidato;

        } catch (\Exception $e) {
            Log::error('Error al procesar la fila: ' . $e->getMessage(), $row);
            return null;
        }
    }
}
