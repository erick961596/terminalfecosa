<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') – Admin FECOSA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        :root {
            --red:#cc1e37; --red-dk:#a3152b; --red-lt:#fdeaed;
            --sidebar:#1a1a1a; --sidebar-w:240px;
            --header-h:60px; --bg:#f0f0f0;
            --dark:#262626; --white:#fff;
        }
        * { box-sizing: border-box; }
        body { font-family:'Nunito',sans-serif; background:var(--bg); margin:0; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: var(--sidebar);
            display: flex; flex-direction: column;
            z-index: 100; overflow-y: auto;
            transition: transform .3s;
        }
        .sidebar-brand {
            padding: 1.25rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand .brand-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800; font-size: 1.2rem; color: #fff;
        }
        .sidebar-brand .brand-tag {
            font-size: .62rem; color: var(--red); font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.5px;
        }
        .sidebar-badge {
            background: var(--red); color: #fff;
            font-size: .6rem; font-weight: 800;
            padding: 1px 6px; border-radius: 4px;
            margin-left: 6px; vertical-align: middle;
        }

        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .nav-section-title {
            font-size: .65rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 1.5px;
            color: rgba(255,255,255,.3); padding: .5rem 1.2rem .25rem;
        }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: .6rem 1.2rem;
            color: rgba(255,255,255,.65); font-weight: 600; font-size: .88rem;
            text-decoration: none; border-radius: 0;
            transition: all .18s;
            border-left: 3px solid transparent;
        }
        .sidebar-nav a:hover { color: #fff; background: rgba(255,255,255,.06); }
        .sidebar-nav a.active {
            color: #fff; background: rgba(204,30,55,.15);
            border-left-color: var(--red);
        }
        .sidebar-nav a i { width: 18px; text-align: center; font-size: .9rem; }

        .sidebar-footer {
            padding: 1rem 1.2rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-footer .admin-name {
            font-weight: 700; font-size: .88rem; color: #fff;
        }
        .sidebar-footer .admin-email {
            font-size: .72rem; color: rgba(255,255,255,.4);
        }

        /* Main content */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        .main-header {
            background: var(--white);
            height: var(--header-h);
            display: flex; align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            position: sticky; top: 0; z-index: 50;
            gap: 1rem;
        }
        .main-header .page-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700; font-size: 1.25rem; color: var(--dark);
            margin: 0;
        }
        .main-content { padding: 1.5rem; flex: 1; }

        /* Cards */
        .admin-card {
            background: #fff; border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
            border: none; overflow: hidden;
        }
        .admin-card .card-header-custom {
            padding: 1rem 1.25rem .75rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .admin-card .card-title-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700; font-size: 1.1rem; margin: 0;
        }

        /* Stat cards */
        .stat-card {
            background: #fff; border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }
        .stat-card .stat-number {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800; font-size: 2.5rem;
            line-height: 1; color: var(--dark);
        }
        .stat-card .stat-label {
            font-size: .8rem; font-weight: 700;
            color: #999; text-transform: uppercase; letter-spacing: .5px;
        }
        .stat-card .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
        }

        /* Buttons */
        .btn-fecosa {
            background: var(--red); color: #fff; border: none;
            border-radius: 8px; font-weight: 700; font-size: .88rem;
            padding: .5rem 1.1rem;
            transition: background .2s, transform .15s;
        }
        .btn-fecosa:hover { background: var(--red-dk); color: #fff; transform: translateY(-1px); }

        /* Tables */
        .table-fecosa thead th {
            background: #f8f8f8; color: var(--dark);
            font-weight: 700; font-size: .82rem;
            text-transform: uppercase; letter-spacing: .5px;
            border-bottom: 2px solid #eee; padding: .75rem 1rem;
        }
        .table-fecosa tbody td { padding: .7rem 1rem; vertical-align: middle; font-size: .9rem; }
        .table-fecosa tbody tr:hover { background: #fafafa; }

        .badge-ruta {
            background: var(--red-lt); color: var(--red);
            font-weight: 700; font-size: .75rem;
            border-radius: 6px; padding: 2px 8px;
        }
        .badge-and {
            background: var(--dark); color: #fff;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700; font-size: .85rem;
            border-radius: 6px; padding: 2px 9px;
        }

        /* Hamburger mobile */
        .sidebar-toggle {
            display: none; background: none; border: none;
            color: var(--dark); font-size: 1.2rem; cursor: pointer;
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .sidebar-overlay {
                position: fixed; inset: 0;
                background: rgba(0,0,0,.5); z-index: 99;
                display: none;
            }
            .sidebar-overlay.show { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name">FECOSA <span class="sidebar-badge">ADMIN</span></div>
        <div class="brand-tag">Panel de Gestión</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-title">General</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>

        <div class="nav-section-title mt-2">Contenido</div>
        <a href="{{ route('admin.rutas.index') }}" class="{{ request()->routeIs('admin.rutas.*') ? 'active' : '' }}">
            <i class="fa-solid fa-route"></i> Rutas
        </a>
        <a href="{{ route('admin.horarios.index') }}" class="{{ request()->routeIs('admin.horarios.*') ? 'active' : '' }}">
            <i class="fa-solid fa-clock"></i> Horarios
        </a>
        <a href="{{ route('admin.features.index') }}" class="{{ request()->routeIs('admin.features.*') ? 'active' : '' }}">
            <i class="fa-solid fa-star"></i> Features Terminal
        </a>

        <div class="nav-section-title mt-2">Acciones</div>
        <a href="{{ route('home') }}" target="_blank">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Ver sitio
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div style="width:32px;height:32px;border-radius:50%;background:var(--red);display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid fa-user" style="color:#fff;font-size:.75rem;"></i>
            </div>
            <div>
                <div class="admin-name">{{ auth('admin')->user()->name ?? 'Admin' }}</div>
                <div class="admin-email">{{ auth('admin')->user()->email ?? '' }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">
            @csrf
            <button type="submit" style="background:none;border:none;color:rgba(255,255,255,.4);font-size:.8rem;font-weight:600;cursor:pointer;padding:0;">
                <i class="fa-solid fa-right-from-bracket me-1"></i>Cerrar sesión
            </button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<div class="main-wrapper">
    <header class="main-header">
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
        <div class="ms-auto d-flex align-items-center gap-2">
            <span style="font-size:.8rem;color:#999;"><i class="fa-regular fa-clock me-1"></i><span id="live-time"></span></span>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// Global AJAX setup
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
});

// Toastr config
toastr.options = {
    positionClass: 'toast-top-right',
    timeOut: 3500,
    closeButton: true,
    progressBar: true,
};

// Live clock
function updateClock() {
    const now = new Date();
    document.getElementById('live-time').textContent =
        now.toLocaleTimeString('es-CR', {hour:'2-digit', minute:'2-digit', second:'2-digit'});
}
setInterval(updateClock, 1000); updateClock();

// Sidebar mobile
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}

// Generic DELETE with SweetAlert
function confirmDelete(url, rowId, tableName) {
    Swal.fire({
        title: '¿Eliminar?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#cc1e37',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url, method: 'DELETE',
                success(res) {
                    if (res.success) {
                        toastr.success(res.message);
                        if (tableName) window[tableName].row('#row-' + rowId).remove().draw();
                    }
                },
                error() { toastr.error('Error al eliminar.'); }
            });
        }
    });
}
</script>

@stack('scripts')
</body>
</html>
