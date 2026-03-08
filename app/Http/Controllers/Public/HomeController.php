<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Ruta;

class HomeController extends Controller
{
    public function index()
    {
        $rutas    = Ruta::activas()->with('horarios')->get();
        $features = Feature::activos()->get();

        return view('public.home.index', compact('rutas', 'features'));
    }
}
