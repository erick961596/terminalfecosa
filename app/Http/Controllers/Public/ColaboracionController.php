<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\ColaboracionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ColaboracionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'     => 'nullable|string|max:100',
            'correo'     => 'nullable|email|max:100',
            'ruta'       => 'required|string|max:150',
            'horarios'   => 'required|string|max:2000',
            'comentario' => 'nullable|string|max:1000',
            'adjunto'    => 'nullable|file|mimes:jpg,jpeg,png,pdf,xlsx,xls|max:5120',
        ], [
            'ruta.required'     => 'Por favor indicá la ruta.',
            'horarios.required' => 'Por favor escribí los horarios que conocés.',
            'adjunto.mimes'     => 'Solo se aceptan imágenes (JPG/PNG), PDF o Excel.',
            'adjunto.max'       => 'El archivo no puede pesar más de 5MB.',
        ]);

        // Handle file upload
        $adjuntoPath = null;
        $adjuntoNombre = null;
        if ($request->hasFile('adjunto')) {
            $file = $request->file('adjunto');
            $adjuntoNombre = $file->getClientOriginalName();
            $adjuntoPath   = $file->store('colaboraciones', 'local');
        }

        // Send email
        Mail::to('alajuelago@gmail.com')->send(
            new ColaboracionMail($data, $adjuntoPath, $adjuntoNombre)
        );

        return response()->json([
            'success' => true,
            'message' => '¡Gracias por tu colaboración! Revisaremos la información pronto.',
        ]);
    }
}
