@extends('layouts.admin')
@section('title', 'Rutas')
@section('page_title', 'Gestión de Rutas')

@section('content')

<div class="admin-card">
    <div class="card-header-custom">
        <span class="card-title-text"><i class="fa-solid fa-route me-2" style="color:#cc1e37;"></i>Rutas ({{ $rutas->count() }})</span>
        <button class="btn-fecosa" onclick="openModal()">
            <i class="fa-solid fa-plus me-1"></i>Nueva Ruta
        </button>
    </div>
    <div class="p-3">
        <table id="rutasTable" class="table table-fecosa w-100">
            <thead>
                <tr>
                    <th>Ruta</th>
                    <th>Andén</th>
                    <th>Slug / SEO</th>
                    <th>Horarios</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rutas as $ruta)
                <tr id="row-{{ $ruta->id }}">
                    <td><span style="font-weight:700;">{{ $ruta->nombreRuta }}</span></td>
                    <td><span class="badge-and">{{ $ruta->anden ?? '—' }}</span></td>
                    <td>
                        <code style="font-size:.78rem;color:#666;">{{ $ruta->slug }}</code>
                        @if($ruta->meta_description)
                            <br><small class="text-muted" style="font-size:.7rem;">
                                <i class="fa-solid fa-magnifying-glass me-1"></i>SEO ✓
                            </small>
                        @endif
                    </td>
                    <td><span class="badge-ruta">{{ $ruta->horarios_count }} registros</span></td>
                    <td>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" {{ $ruta->activa ? 'checked' : '' }}
                                   onchange="toggleActiva({{ $ruta->id }}, this)"
                                   style="cursor:pointer;">
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary me-1" onclick="editRuta({{ $ruta->id }})"
                                title="Editar" style="border-radius:7px;">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button class="btn btn-sm" onclick="confirmDelete('{{ route('admin.rutas.destroy', $ruta->id) }}', {{ $ruta->id }}, 'rutasDT')"
                                style="background:#fdeaed;color:#cc1e37;border:none;border-radius:7px;" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <a href="{{ route('ruta.show', $ruta->slug) }}" target="_blank"
                           class="btn btn-sm btn-outline-secondary" style="border-radius:7px;" title="Ver en sitio">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="rutaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;">
            <div class="modal-header" style="border-bottom:1px solid #f0f0f0;padding:1.25rem 1.5rem;">
                <h5 class="modal-title" id="modalTitle" style="font-family:'Barlow Condensed',sans-serif;font-weight:700;font-size:1.2rem;">Nueva Ruta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="rutaForm">
                    <input type="hidden" id="rutaId">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-600">Nombre de la Ruta *</label>
                            <input type="text" id="nombreRuta" class="form-control" placeholder="Ej: CANOAS - GUADALUPE" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">N° Andén</label>
                            <input type="number" id="anden" class="form-control" placeholder="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Slug <small class="text-muted fw-400">(URL SEO)</small></label>
                            <input type="text" id="slug" class="form-control" placeholder="canoas-guadalupe">
                            <small class="text-muted">Se genera automáticamente si no se llena.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Estado</label>
                            <select id="activa" class="form-select">
                                <option value="1">✅ Activa</option>
                                <option value="0">⏸ Inactiva</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">
                                Meta Description <small class="text-muted fw-400">(SEO – máx. 320 chars)</small>
                            </label>
                            <textarea id="meta_description" class="form-control" rows="2" maxlength="320"
                                      placeholder="Ej: Horarios de buses ruta Canoas – Guadalupe, Terminal FECOSA Alajuela. Consulta salidas y andén 1."></textarea>
                            <small class="text-muted" id="metaCharCount">0 / 320 caracteres</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top:1px solid #f0f0f0;padding:1rem 1.5rem;">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-fecosa" onclick="saveRuta()">
                    <i class="fa-solid fa-floppy-disk me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let rutasDT;

$(document).ready(function() {
    rutasDT = $('#rutasTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
        },
        order: [[0, 'asc']],
        pageLength: 25,
        columnDefs: [{ orderable: false, targets: [5] }]
    });
});

// Meta char counter
document.getElementById('meta_description').addEventListener('input', function() {
    document.getElementById('metaCharCount').textContent = `${this.value.length} / 320 caracteres`;
});

// Auto-generate slug from nombre
document.getElementById('nombreRuta').addEventListener('blur', function() {
    if (!document.getElementById('slug').value) {
        document.getElementById('slug').value = this.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
            .replace(/[^a-z0-9\s-]/g,'')
            .replace(/\s+/g,'-')
            .replace(/-+/g,'-').trim();
    }
});

function openModal(id = null) {
    document.getElementById('rutaId').value = '';
    document.getElementById('rutaForm').reset();
    document.getElementById('metaCharCount').textContent = '0 / 320 caracteres';
    document.getElementById('modalTitle').textContent = 'Nueva Ruta';
    new bootstrap.Modal(document.getElementById('rutaModal')).show();
}

function editRuta(id) {
    $.get(`/admin/rutas/${id}`, function(ruta) {
        document.getElementById('rutaId').value = ruta.id;
        document.getElementById('nombreRuta').value = ruta.nombreRuta;
        document.getElementById('anden').value = ruta.anden || '';
        document.getElementById('slug').value = ruta.slug;
        document.getElementById('activa').value = ruta.activa ? '1' : '0';
        document.getElementById('meta_description').value = ruta.meta_description || '';
        document.getElementById('metaCharCount').textContent = `${(ruta.meta_description||'').length} / 320 caracteres`;
        document.getElementById('modalTitle').textContent = 'Editar Ruta: ' + ruta.nombreRuta;
        new bootstrap.Modal(document.getElementById('rutaModal')).show();
    });
}

function saveRuta() {
    const id = document.getElementById('rutaId').value;
    const url    = id ? `/admin/rutas/${id}` : '/admin/rutas';
    const method = id ? 'PUT' : 'POST';

    const data = {
        nombreRuta:       document.getElementById('nombreRuta').value,
        anden:            document.getElementById('anden').value,
        slug:             document.getElementById('slug').value,
        activa:           document.getElementById('activa').value,
        meta_description: document.getElementById('meta_description').value,
    };

    $.ajax({
        url, method, data,
        success(res) {
            if (res.success) {
                toastr.success(res.message);
                bootstrap.Modal.getInstance(document.getElementById('rutaModal')).hide();
                setTimeout(() => location.reload(), 800);
            }
        },
        error(xhr) {
            const errs = xhr.responseJSON?.errors;
            if (errs) toastr.error(Object.values(errs).flat().join('<br>'));
            else toastr.error('Error al guardar.');
        }
    });
}

function toggleActiva(id, checkbox) {
    $.put = (url, data, cb) => $.ajax({url, method:'PUT', data, success:cb});
    $.ajax({
        url: `/admin/rutas/${id}`,
        method: 'PUT',
        data: { activa: checkbox.checked ? 1 : 0, _method: 'PUT' },
        success(res) { toastr.success(res.message); },
        error() { checkbox.checked = !checkbox.checked; toastr.error('Error.'); }
    });
}
</script>
@endpush
