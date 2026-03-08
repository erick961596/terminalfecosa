@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

<div class="row g-3 mb-4">
    <!-- Stat cards -->
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <div class="stat-number">{{ $stats['rutas'] }}</div>
                    <div class="stat-label">Rutas totales</div>
                </div>
                <div class="stat-icon" style="background:#fdeaed;">
                    <i class="fa-solid fa-route" style="color:#cc1e37;"></i>
                </div>
            </div>
            <div style="font-size:.78rem;color:#999;">
                <span style="color:#22c55e;font-weight:700;">{{ $stats['activas'] }}</span> activas
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <div class="stat-number">{{ $stats['horarios'] }}</div>
                    <div class="stat-label">Registros horarios</div>
                </div>
                <div class="stat-icon" style="background:#eff6ff;">
                    <i class="fa-solid fa-clock" style="color:#3b82f6;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <div class="stat-number">{{ $stats['activas'] }}</div>
                    <div class="stat-label">Rutas activas</div>
                </div>
                <div class="stat-icon" style="background:#f0fdf4;">
                    <i class="fa-solid fa-circle-check" style="color:#22c55e;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <div class="stat-number">{{ $stats['features'] }}</div>
                    <div class="stat-label">Features terminal</div>
                </div>
                <div class="stat-icon" style="background:#fefce8;">
                    <i class="fa-solid fa-star" style="color:#eab308;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Rutas recientes -->
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="card-header-custom">
                <span class="card-title-text">Rutas recientes</span>
                <a href="{{ route('admin.rutas.index') }}" class="btn-fecosa" style="font-size:.8rem;">Ver todas</a>
            </div>
            <div class="p-0">
                <table class="table table-fecosa mb-0">
                    <thead>
                        <tr>
                            <th>Ruta</th>
                            <th>Andén</th>
                            <th>Slug</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rutasRecientes as $ruta)
                        <tr>
                            <td class="fw-600">{{ $ruta->nombreRuta }}</td>
                            <td><span class="badge-and">{{ $ruta->anden ?? '—' }}</span></td>
                            <td><code style="font-size:.75rem;color:#999;">{{ $ruta->slug }}</code></td>
                            <td>
                                @if($ruta->activa)
                                    <span class="badge" style="background:#f0fdf4;color:#16a34a;font-size:.72rem;">Activa</span>
                                @else
                                    <span class="badge" style="background:#fef2f2;color:#dc2626;font-size:.72rem;">Inactiva</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="col-lg-5">
        <div class="admin-card h-100">
            <div class="card-header-custom">
                <span class="card-title-text">Accesos rápidos</span>
            </div>
            <div class="p-3 d-flex flex-column gap-2">
                <a href="{{ route('admin.rutas.index') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
                   style="background:#fdeaed;color:#cc1e37;transition:opacity .2s;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
                    <i class="fa-solid fa-route fa-lg"></i>
                    <div>
                        <div style="font-weight:700;font-size:.9rem;">Gestionar Rutas</div>
                        <div style="font-size:.75rem;opacity:.7;">Agregar, editar o eliminar rutas</div>
                    </div>
                    <i class="fa-solid fa-chevron-right ms-auto"></i>
                </a>
                <a href="{{ route('admin.horarios.index') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
                   style="background:#eff6ff;color:#3b82f6;transition:opacity .2s;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
                    <i class="fa-solid fa-clock fa-lg"></i>
                    <div>
                        <div style="font-weight:700;font-size:.9rem;">Gestionar Horarios</div>
                        <div style="font-size:.75rem;opacity:.7;">CRUD + importación CSV</div>
                    </div>
                    <i class="fa-solid fa-chevron-right ms-auto"></i>
                </a>
                <a href="{{ route('admin.features.index') }}" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
                   style="background:#fefce8;color:#ca8a04;transition:opacity .2s;" onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
                    <i class="fa-solid fa-star fa-lg"></i>
                    <div>
                        <div style="font-weight:700;font-size:.9rem;">Features Terminal</div>
                        <div style="font-size:.75rem;opacity:.7;">Comodidades de la terminal</div>
                    </div>
                    <i class="fa-solid fa-chevron-right ms-auto"></i>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
                   style="background:#f8f8f8;color:#262626;transition:opacity .2s;" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">
                    <i class="fa-solid fa-eye fa-lg"></i>
                    <div>
                        <div style="font-weight:700;font-size:.9rem;">Ver sitio público</div>
                        <div style="font-size:.75rem;opacity:.5;">Abre en nueva pestaña</div>
                    </div>
                    <i class="fa-solid fa-arrow-up-right-from-square ms-auto"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
