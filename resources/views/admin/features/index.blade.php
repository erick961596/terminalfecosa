@extends('layouts.admin')
@section('title', 'Features Terminal')
@section('page_title', 'Features Terminal')

@section('content')

<div class="row g-3">
    <!-- Table -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header-custom">
                <span class="card-title-text"><i class="fa-solid fa-star me-2" style="color:#eab308;"></i>Comodidades de la Terminal</span>
                <button class="btn-fecosa" onclick="openFeatureModal()">
                    <i class="fa-solid fa-plus me-1"></i>Nueva Feature
                </button>
            </div>
            <div class="p-3">
                <table id="featuresTable" class="table table-fecosa w-100">
                    <thead>
                        <tr>
                            <th>Orden</th>
                            <th>Icono</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="featuresBody">
                        @foreach($features as $f)
                        <tr id="row-{{ $f->id }}">
                            <td style="color:#999;">{{ $f->orden }}</td>
                            <td style="font-size:1.3rem;"><i class="{{ $f->icono }}" style="color:#cc1e37;"></i></td>
                            <td><strong>{{ $f->nombre }}</strong></td>
                            <td style="font-size:.82rem;color:#666;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $f->descripcion ?? '—' }}
                            </td>
                            <td>
                                <span style="background:{{ $f->activo ? '#f0fdf4' : '#fef2f2' }};color:{{ $f->activo ? '#16a34a' : '#dc2626' }};font-size:.72rem;padding:2px 8px;border-radius:5px;font-weight:700;">
                                    {{ $f->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary me-1" onclick="editFeature({{ $f->id }})" style="border-radius:7px;">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-sm" onclick="confirmDelete('{{ route('admin.features.destroy', $f->id) }}', {{ $f->id }}, 'featuresDT')"
                                        style="background:#fdeaed;color:#cc1e37;border:none;border-radius:7px;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Icon Picker Preview -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="card-header-custom">
                <span class="card-title-text">Íconos sugeridos</span>
            </div>
            <div class="p-3">
                <p class="text-muted" style="font-size:.82rem;">Haz clic para copiar la clase al formulario:</p>
                <div class="d-flex flex-wrap gap-2" id="iconSuggestions">
                    @php
                    $icons = [
                        'fa-solid fa-store'           => 'Locales',
                        'fa-solid fa-umbrella'         => 'Paradas',
                        'fa-solid fa-signs-post'       => 'Señalización',
                        'fa-solid fa-restroom'         => 'Sanitarios',
                        'fa-solid fa-arrows-left-right'=> 'Espacios',
                        'fa-solid fa-shield-halved'    => 'Seguridad',
                        'fa-solid fa-tree'             => 'Zonas verdes',
                        'fa-solid fa-star'             => 'Comodidades',
                        'fa-solid fa-wifi'             => 'WiFi',
                        'fa-solid fa-wheelchair'       => 'Accesible',
                        'fa-solid fa-utensils'         => 'Comida',
                        'fa-solid fa-bus'              => 'Buses',
                        'fa-solid fa-parking'          => 'Parqueo',
                        'fa-solid fa-baby'             => 'Familias',
                        'fa-solid fa-camera'           => 'Cámaras',
                        'fa-solid fa-map-location-dot' => 'Mapa',
                    ];
                    @endphp
                    @foreach($icons as $class => $label)
                    <button class="btn btn-sm" onclick="copyIcon('{{ $class }}')"
                            title="{{ $label }}: {{ $class }}"
                            style="background:#f8f8f8;border:1px solid #eee;border-radius:8px;padding:.4rem .6rem;transition:all .15s;"
                            onmouseover="this.style.background='#fdeaed'" onmouseout="this.style.background='#f8f8f8'">
                        <i class="{{ $class }}" style="color:#cc1e37;"></i>
                    </button>
                    @endforeach
                </div>
                <div id="iconCopied" class="mt-2" style="display:none;">
                    <small class="text-success"><i class="fa-solid fa-check me-1"></i>Copiado: <code id="iconCopiedText"></code></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL Feature -->
<div class="modal fade" id="featureModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:16px;border:none;">
            <div class="modal-header" style="border-bottom:1px solid #f0f0f0;padding:1.25rem 1.5rem;">
                <h5 class="modal-title" id="featureModalTitle" style="font-family:'Barlow Condensed',sans-serif;font-weight:700;font-size:1.2rem;">Nueva Feature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="featureId">
                <div class="row g-3">
                    <div class="col-8">
                        <label class="form-label fw-600">Nombre *</label>
                        <input type="text" id="feature_nombre" class="form-control" placeholder="Locales Comerciales" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label fw-600">Orden</label>
                        <input type="number" id="feature_orden" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600">Clase de Ícono FontAwesome *</label>
                        <div class="input-group">
                            <span class="input-group-text" id="iconPreview"><i class="fa-solid fa-star" style="color:#cc1e37;"></i></span>
                            <input type="text" id="feature_icono" class="form-control"
                                   placeholder="fa-solid fa-store"
                                   oninput="previewIcon(this.value)" required>
                        </div>
                        <small class="text-muted">Ej: <code>fa-solid fa-store</code>, <code>fa-solid fa-umbrella</code></small>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600">Descripción</label>
                        <textarea id="feature_descripcion" class="form-control" rows="2"
                                  placeholder="Breve descripción de esta comodidad..."></textarea>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-600">Estado</label>
                        <select id="feature_activo" class="form-select">
                            <option value="1">✅ Activo</option>
                            <option value="0">⏸ Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #f0f0f0;padding:1rem 1.5rem;">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-fecosa" onclick="saveFeature()">
                    <i class="fa-solid fa-floppy-disk me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let featuresDT;
const featuresData = @json($features->keyBy('id'));

$(document).ready(function() {
    featuresDT = $('#featuresTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' },
        order: [[0, 'asc']], pageLength: 25,
        columnDefs: [{ orderable: false, targets: [5] }]
    });
});

function previewIcon(cls) {
    const preview = document.getElementById('iconPreview');
    preview.innerHTML = `<i class="${cls}" style="color:#cc1e37;"></i>`;
}

function copyIcon(cls) {
    document.getElementById('feature_icono').value = cls;
    previewIcon(cls);
    document.getElementById('iconCopiedText').textContent = cls;
    document.getElementById('iconCopied').style.display = 'block';
    setTimeout(() => document.getElementById('iconCopied').style.display = 'none', 2000);
}

function openFeatureModal() {
    document.getElementById('featureId').value = '';
    document.getElementById('feature_nombre').value = '';
    document.getElementById('feature_icono').value = '';
    document.getElementById('feature_descripcion').value = '';
    document.getElementById('feature_orden').value = '0';
    document.getElementById('feature_activo').value = '1';
    document.getElementById('featureModalTitle').textContent = 'Nueva Feature';
    previewIcon('fa-solid fa-star');
    new bootstrap.Modal(document.getElementById('featureModal')).show();
}

function editFeature(id) {
    const f = featuresData[id];
    document.getElementById('featureId').value = f.id;
    document.getElementById('feature_nombre').value = f.nombre;
    document.getElementById('feature_icono').value = f.icono;
    document.getElementById('feature_descripcion').value = f.descripcion || '';
    document.getElementById('feature_orden').value = f.orden;
    document.getElementById('feature_activo').value = f.activo ? '1' : '0';
    document.getElementById('featureModalTitle').textContent = 'Editar: ' + f.nombre;
    previewIcon(f.icono);
    new bootstrap.Modal(document.getElementById('featureModal')).show();
}

function saveFeature() {
    const id  = document.getElementById('featureId').value;
    const url = id ? `/admin/features/${id}` : '/admin/features';

    $.ajax({
        url, method: id ? 'PUT' : 'POST',
        data: {
            nombre:      document.getElementById('feature_nombre').value,
            icono:       document.getElementById('feature_icono').value,
            descripcion: document.getElementById('feature_descripcion').value,
            orden:       document.getElementById('feature_orden').value,
            activo:      document.getElementById('feature_activo').value,
        },
        success(res) {
            if (res.success) {
                toastr.success(res.message);
                bootstrap.Modal.getInstance(document.getElementById('featureModal')).hide();
                setTimeout(() => location.reload(), 800);
            }
        },
        error() { toastr.error('Error al guardar.'); }
    });
}
</script>
@endpush
