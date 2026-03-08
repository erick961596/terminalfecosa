<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RutaController extends Controller
{
    public function index()
    {
        $rutas = Ruta::withCount('horarios')->orderBy('nombreRuta')->get();
        return view('admin.rutas.index', compact('rutas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombreRuta'       => 'required|string|max:100',
            'anden'            => 'nullable|integer',
            'slug'             => 'nullable|string|max:100|unique:rutas,slug',
            'meta_description' => 'nullable|string|max:320',
            'activa'           => 'boolean',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nombreRuta']);
        }

        $ruta = Ruta::create($data);

        return response()->json(['success' => true, 'ruta' => $ruta, 'message' => 'Ruta creada correctamente.']);
    }

    public function update(Request $request, Ruta $ruta)
    {
        $data = $request->validate([
            'nombreRuta'       => 'required|string|max:100',
            'anden'            => 'nullable|integer',
            'slug'             => 'nullable|string|max:100|unique:rutas,slug,' . $ruta->id,
            'meta_description' => 'nullable|string|max:320',
            'activa'           => 'boolean',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nombreRuta']);
        }

        $ruta->update($data);

        return response()->json(['success' => true, 'ruta' => $ruta, 'message' => 'Ruta actualizada correctamente.']);
    }

    public function destroy(Ruta $ruta)
    {
        $ruta->delete();
        return response()->json(['success' => true, 'message' => 'Ruta eliminada.']);
    }

    public function show(Ruta $ruta)
    {
        $ruta->load('horarios');
        return response()->json($ruta);
    }
}
