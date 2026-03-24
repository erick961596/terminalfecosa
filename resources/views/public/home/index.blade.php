@extends('layouts.public')

@section('title', 'Horarios de Buses – Terminal FECOSA Alajuela')
@section('meta_description', 'Consulta los horarios de buses de todas las rutas de la Terminal FECOSA, Alajuela, Costa Rica. ¡Como Alajuela se merece!')

@section('content')

<!-- HERO + SEARCH -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-tagline mb-2">
                   <h1>HORARIOS DE <span class="red">BUSES</span><br>TERMINAL FECOSA</h1>
                </div>
                <p class="hero-sub mb-4">Esta página no está vinculada con la Municipalidad de Alajuela ni con Terminal Fecosa, es un proyecto comunitario. Consulta las salidas de todas las rutas del Cantón de Alajuela · {{ $rutas->count() }} rutas disponibles</p>
            </div>
        </div>

        <!-- Search -->
        <div class="search-input-group">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="searchInput" placeholder="Buscar ruta… ej: Cacao, Atenas, Carrizal"
                   autocomplete="off" oninput="debounceSearch(this.value)">
            <div class="search-results-dropdown" id="searchDropdown"></div>
        </div>
    </div>
</div>

<!-- ROUTES GRID -->
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h2 class="section-title mb-0">
            TODAS LAS <span class="accent">RUTAS</span>
        </h2>
        <span class="tag-label">{{ $rutas->count() }} rutas activas</span>
    </div>

    <!-- Filter pills -->
    <div class="d-flex gap-2 flex-wrap mb-4" id="filterPills">
        <button class="btn btn-sm filter-pill active" data-filter="all"
                style="border-radius:50px;font-weight:700;font-size:.82rem;border:1.5px solid #cc1e37;background:#cc1e37;color:#fff;padding:.35rem 1rem;">
            Todas
        </button>
        <button class="btn btn-sm filter-pill" data-filter="lv"
                style="border-radius:50px;font-weight:700;font-size:.82rem;border:1.5px solid #e0e0e0;background:#fff;color:#262626;padding:.35rem 1rem;">
            Lun – Vie
        </button>
        <button class="btn btn-sm filter-pill" data-filter="sab"
                style="border-radius:50px;font-weight:700;font-size:.82rem;border:1.5px solid #e0e0e0;background:#fff;color:#262626;padding:.35rem 1rem;">
            Sábado
        </button>
        <button class="btn btn-sm filter-pill" data-filter="dom"
                style="border-radius:50px;font-weight:700;font-size:.82rem;border:1.5px solid #e0e0e0;background:#fff;color:#262626;padding:.35rem 1rem;">
            Domingo
        </button>
    </div>

    <div class="row g-3" id="rutasGrid">
        @forelse($rutas as $ruta)
        <div class="col-6 col-md-4 col-lg-3 route-item">
            <a href="{{ route('ruta.show', $ruta->slug) }}" class="route-card">
                <div class="card-stripe"></div>
                <div class="card-body-custom">
                    <div class="d-flex align-items-start justify-content-between gap-1 mb-2">
                        <div>
                            <div class="anden-label">ANDÉN</div>
                            <div class="anden-num">{{ $ruta->anden ?? '—' }}</div>
                        </div>
                        <i class="fa-solid fa-chevron-right arrow-icon mt-1"></i>
                    </div>
                    <div class="route-name-text mb-1">{{ $ruta->nombreRuta }}</div>
                    <div class="horarios-count">
                        <i class="fa-regular fa-clock me-1"></i>
                        {{ $ruta->horarios->count() }} {{ Str::plural('horario', $ruta->horarios->count()) }}
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fa-solid fa-bus fa-3x mb-3 d-block" style="opacity:.3;"></i>
            No hay rutas disponibles.
        </div>
        @endforelse
    </div>
</div>

<!-- SUPERCANCHA BANNER AD -->
<div class="container pb-4 pt-1">
    <div class="supercancha-banner">
        <div class="sc-badge">Alquiler de canchas deportivas</div>
        <div class="sc-content">
            <div class="sc-left">
                <div class="sc-icon">
                    <i class="fa-solid fa-futbol"></i>
                </div>
                <div class="sc-text">
                    <div class="sc-title">SuperCancha</div>
                    <div class="sc-desc">Encontrá y reservá canchas deportivas cerca de vos. Fútbol, Pádel,  básquet, tenis y más.</div>
                </div>
            </div>
            <a href="https://supercancha.com/?utm_source=terminal_fecosa&utm_medium=cpc" class="sc-btn">
                Conocer <i class="fa-solid fa-arrow-right ms-1" style="font-size:.75rem;"></i>
            </a>
        </div>
        <div class="sc-ad-label">Proyecto comunitario</div>
    </div>
</div>

<style>
.supercancha-banner {
    position: relative;
    background: #fff;
    border: 1.5px solid #e8e8e8;
    border-radius: 12px;
    padding: .75rem 1rem .75rem 1rem;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.supercancha-banner::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    background: #cc1e37;
    border-radius: 12px 0 0 12px;
}
.sc-badge {
    display: inline-block;
    font-size: .6rem;
    font-weight: 800;
    letter-spacing: .08em;
    color: #cc1e37;
    background: rgba(204,30,55,.08);
    border-radius: 50px;
    padding: .15rem .55rem;
    margin-bottom: .45rem;
    text-transform: uppercase;
}
.sc-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.sc-left {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex: 1;
    min-width: 0;
}
.sc-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #cc1e37 0%, #a01526 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1rem;
    flex-shrink: 0;
}
.sc-title {
    font-weight: 800;
    font-size: .95rem;
    color: #1a1a1a;
    line-height: 1.2;
    white-space: nowrap;
}
.sc-cr { color: #cc1e37; }
.sc-desc {
    font-size: .75rem;
    color: #777;
    margin-top: .1rem;
    line-height: 1.35;
}
.sc-btn {
    display: inline-flex;
    align-items: center;
    background: #cc1e37;
    color: #fff !important;
    font-weight: 700;
    font-size: .78rem;
    padding: .45rem 1rem;
    border-radius: 50px;
    text-decoration: none !important;
    white-space: nowrap;
    transition: background .18s, transform .15s;
    flex-shrink: 0;
}
.sc-btn:hover {
    background: #a01526;
    transform: translateY(-1px);
}
.sc-ad-label {
    position: absolute;
    top: .4rem;
    right: .6rem;
    font-size: .55rem;
    color: #bbb;
    letter-spacing: .04em;
    text-transform: uppercase;
}
@media (max-width: 480px) {
    .sc-desc { display: none; }
    .sc-title { font-size: .85rem; }
}
</style>

<!-- FEATURES SECTION -->
@if($features->count())
<section class="features-section py-5 mt-2" id="features">
    <div class="container">
        <div class="text-center mb-4">
            <div class="section-title text-white mb-1">
                COMODIDADES DE LA <span style="color:#cc1e37;">TERMINAL</span>
            </div>
            <p style="color:rgba(255,255,255,.5);font-size:.9rem;">¡Como Alajuela se merece!</p>
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content: center">
            @foreach($features as $feature)
            <div class="feature-pill">
                <i class="{{ $feature->icono }}"></i>
                <span>{{ $feature->nombre }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
let searchTimer;

function debounceSearch(q) {
    clearTimeout(searchTimer);
    if (q.length < 2) {
        closeDropdown(); return;
    }
    searchTimer = setTimeout(() => doSearch(q), 280);
}

function doSearch(q) {
    fetch(`/api/rutas/search?q=${encodeURIComponent(q)}`)
        .then(r => r.json())
        .then(data => renderDropdown(data));
}

function renderDropdown(rutas) {
    const dd = document.getElementById('searchDropdown');
    if (!rutas.length) {
        dd.innerHTML = `<div class="p-3 text-center text-muted" style="font-size:.85rem;">Sin resultados</div>`;
        dd.classList.add('show'); return;
    }
    dd.innerHTML = rutas.map(r => `
        <a href="${r.url}" class="search-result-item">
            <span class="anden-badge">Andén ${r.anden || '?'}</span>
            <div>
                <div class="route-name">${r.nombre}</div>
                <div class="route-meta">${r.horarios} horarios</div>
            </div>
            <i class="fa-solid fa-arrow-right ms-auto" style="color:#cc1e37;font-size:.8rem;"></i>
        </a>
    `).join('');
    dd.classList.add('show');
}

function closeDropdown() {
    document.getElementById('searchDropdown').classList.remove('show');
}

document.addEventListener('click', e => {
    if (!e.target.closest('.search-input-group')) closeDropdown();
});

// Filter pills
document.querySelectorAll('.filter-pill').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-pill').forEach(b => {
            b.style.background = '#fff';
            b.style.color = '#262626';
            b.style.borderColor = '#e0e0e0';
        });
        this.style.background = '#cc1e37';
        this.style.color = '#fff';
        this.style.borderColor = '#cc1e37';
    });
});
</script>
@endpush
