<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Ruta;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function show(string $slug)
    {
        $ruta = Ruta::where('slug', $slug)->where('activa', true)->with('horarios')->firstOrFail();

        $metaDescription = $ruta->meta_description ?: $ruta->meta_description_default;

        return view('public.rutas.show', compact('ruta', 'metaDescription'));
    }

    public function search(Request $request)
    {
        $q = $request->input('q', '');

        $rutas = Ruta::activas()
            ->where(function ($query) use ($q) {
                $query->where('nombreRuta', 'like', "%{$q}%")
                      ->orWhere('anden', 'like', "%{$q}%");
            })
            ->with('horarios')
            ->get()
            ->map(fn($r) => [
                'id'         => $r->id,
                'nombre'     => $r->nombreRuta,
                'anden'      => $r->anden,
                'slug'       => $r->slug,
                'url'        => route('ruta.show', $r->slug),
                'horarios'   => $r->horarios->count(),
            ]);

        return response()->json($rutas);
    }
}
