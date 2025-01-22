<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParticipantesImport;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPasswordMail;

class EmpresaImportController extends Controller
{
    public function importar(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        Excel::import(new ParticipantesImport, $request->file('file'));

        return redirect()->back()->with('success', 'Participantes importados correctamente.');
    }
}
