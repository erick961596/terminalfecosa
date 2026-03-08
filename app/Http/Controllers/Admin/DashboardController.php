<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Horario;
use App\Models\Ruta;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'rutas'    => Ruta::count(),
            'activas'  => Ruta::where('activa', true)->count(),
            'horarios' => Horario::count(),
            'features' => Feature::count(),
        ];

        $rutasRecientes = Ruta::latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'rutasRecientes'));
    }
}
