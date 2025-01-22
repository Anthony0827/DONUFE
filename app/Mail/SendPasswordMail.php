<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Candidato;  // Cambia de Usuario a Candidato

class SendPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidato;  // Cambia 'user' a 'candidato'
    public $password;

    public function __construct(Candidato $candidato, $password)
    {
        $this->candidato = $candidato;  // Cambia 'user' por 'candidato'
        $this->password = $password;
    }

public function build()
{
    return $this->view('emails.send_password')
                ->with([
                    'email' => $this->candidato->email, // Pasar el correo electrónico correctamente
                    'clave' => $this->password, // Pasar la contraseña generada
                ]);
}

}
