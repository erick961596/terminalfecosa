<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('orden')->get();
        return view('admin.features.index', compact('features'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'icono'       => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'orden'       => 'integer',
            'activo'      => 'boolean',
        ]);

        $feature = Feature::create($data);
        return response()->json(['success' => true, 'feature' => $feature, 'message' => 'Característica creada.']);
    }

    public function update(Request $request, Feature $feature)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'icono'       => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'orden'       => 'integer',
            'activo'      => 'boolean',
        ]);

        $feature->update($data);
        return response()->json(['success' => true, 'feature' => $feature, 'message' => 'Característica actualizada.']);
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return response()->json(['success' => true, 'message' => 'Característica eliminada.']);
    }
}
