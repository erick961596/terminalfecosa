@extends('layouts.admin')
@section('title', 'Horarios')
@section('page_title', 'Gestión de Horarios')

@section('content')

<!-- Import CSV Banner -->
<div class="admin-card mb-3" style="border-left:4px solid #3b82f6;">
    <div class="card-header-custom">
        <span class="card-title-text"><i class="fa-solid fa-file-csv me-2" style="color:#3b82f6;"></i>Importar Horarios por CSV</span>
        <button class="btn btn-outline-primary btn-sm fw-600" onclick="bootstrap.Modal.getInstance(document.getElementById('csvModal')) || new bootstrap.Modal(document.getElementById('csvModal')); document.getElementById('csvModal') && new bootstrap.Modal(document.getElementById('csvModal')).show()">
            <i class="fa-solid fa-upload me-1"></i>Importar CSV
        </button>
    </div>
    <div class="p-3 pt-0">
        <small class="text-muted">
            Formato esperado: <code>ruta_id (o slug), horas_separadas_por_coma, dias</code> · Ejemplo: <code>15,"04:45, 05:10, 06:00","1,2,3,4,5"</code>
        </small>
    </div>
</div>

<!-- Table -->
<div class="admin-card">
    <div class="card-header-custom">
        <span class="card-title-text"><i class="fa-solid fa-clock me-2" style="color:#cc1e37;"></i>Horarios registrados</span>
        <button class="btn-fecosa" onclick="openHorarioModal()">
            <i class="fa-solid fa-plus me-1"></i>Nuevo Horario
        </button>
    </div>
    <div class="p-3">
        <table id="horariosTable" class="table table-fecosa w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ruta</th>
                    <th>Días</th>
                    <th>Salidas</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horarios as $h)
                <tr id="row-{{ $h->id }}">
                    <td style="color:#999;font-size:.8rem;">{{ $h->id }}</td>
                    <td>
                        <span class="badge-ruta">{{ $h->ruta->nombreRuta ?? 'N/A' }}</span>
                        <br><small class="text-muted" style="font-size:.72rem;">Andén {{ $h->ruta->anden ?? '?' }}</small>
                    </td>
                    <td><strong style="font-size:.85rem;">{{ $h->dias_label }}</strong></td>
                    <td>
                        <span style="font-size:.78rem;color:#666;max-width:300px;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $h->horarioSalidaTerminal }}
                        </span>
                        <small class="text-muted">{{ count($h->horas_array) }} salidas</small>
                    </td>
                    <td>
                        <span class="{{ $h->activo ? 'badge' : 'badge' }}"
                              style="background:{{ $h->activo ? '#f0fdf4' : '#fef2f2' }};color:{{ $h->activo ? '#16a34a' : '#dc2626' }};font-size:.72rem;">
                            {{ $h->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary me-1" onclick="editHorario({{ $h->id }})"
                                style="border-radius:7px;" title="Editar">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button class="btn btn-sm" onclick="confirmDelete('{{ route('admin.horarios.destroy', $h->id) }}', {{ $h->id }}, 'horariosDT')"
                                style="background:#fdeaed;color:#cc1e37;border:none;border-radius:7px;" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL Horario -->
<div class="modal fade" id="horarioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;">
            <div class="modal-header" style="border-bottom:1px solid #f0f0f0;padding:1.25rem 1.5rem;">
                <h5 class="modal-title" id="horarioModalTitle" style="font-family:'Barlow Condensed',sans-serif;font-weight:700;font-size:1.2rem;">Nuevo Horario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="horarioId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Ruta *</label>
                        <select id="horario_ruta_id" class="form-select select2-ruta" required>
                            <option value="">-- Seleccionar ruta --</option>
                            @foreach($rutas as $ruta)
                            <option value="{{ $ruta->id }}">Andén {{ $ruta->anden }} – {{ $ruta->nombreRuta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Días de operación *</label>
                        <select id="horario_dias" class="form-select select2-dias" multiple required>
                            <option value="1">1 – Lunes</option>
                            <option value="2">2 – Martes</option>
                            <option value="3">3 – Miércoles</option>
                            <option value="4">4 – Jueves</option>
                            <option value="5">5 – Viernes</option>
                            <option value="6">6 – Sábado</option>
                            <option value="7">7 – Domingo</option>
                        </select>
                        <small class="text-muted">Se guardará como "1,2,3,4,5"</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600">
                            Horarios de salida *
                            <small class="text-muted fw-400">(separados por coma)</small>
                        </label>
                        <textarea id="horario_horas" class="form-control" rows="3" required
                                  placeholder="04:45, 05:10, 05:30, 06:00, 07:00, 08:00, ..."></textarea>
                        <small class="text-muted">Ingresa las horas en formato HH:MM separadas por comas.</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600">Estado</label>
                        <select id="horario_activo" class="form-select">
                            <option value="1">✅ Activo</option>
                            <option value="0">⏸ Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #f0f0f0;padding:1rem 1.5rem;">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-fecosa" onclick="saveHorario()">
                    <i class="fa-solid fa-floppy-disk me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CSV -->
<div class="modal fade" id="csvModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:16px;border:none;">
            <div class="modal-header" style="border-bottom:1px solid #f0f0f0;padding:1.25rem 1.5rem;">
                <h5 class="modal-title" style="font-family:'Barlow Condensed',sans-serif;font-weight:700;font-size:1.2rem;">
                    <i class="fa-solid fa-file-csv me-2" style="color:#3b82f6;"></i>Importar Horarios CSV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info py-2 px-3 mb-3" style="font-size:.83rem;border-radius:8px;">
                    <strong>Formato del CSV:</strong><br>
                    Columna 1: ID o slug de la ruta<br>
                    Columna 2: Horas separadas por coma<br>
                    Columna 3: Días (1=Lun, 2=Mar, ..., 7=Dom)<br>
                    <code>15,"04:45, 05:10, 06:00","1,2,3,4,5"</code>
                </div>
                <label class="form-label fw-600">Seleccionar archivo CSV</label>
                <input type="file" id="csvFile" class="form-control" accept=".csv,.txt">
                <div id="csvProgress" style="display:none;" class="mt-3">
                    <div class="progress" style="height:6px;border-radius:3px;">
                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width:100%"></div>
                    </div>
                    <small class="text-muted mt-1 d-block">Procesando...</small>
                </div>
                <div id="csvResult" class="mt-3" style="display:none;"></div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #f0f0f0;padding:1rem 1.5rem;">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary fw-600" onclick="importCsv()" style="border-radius:8px;">
                    <i class="fa-solid fa-upload me-1"></i>Importar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let horariosDT;

$(document).ready(function() {
    horariosDT = $('#horariosTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' },
        order: [[1, 'asc']],
        pageLength: 25,
        columnDefs: [{ orderable: false, targets: [5] }]
    });

    $('.select2-ruta').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#horarioModal'),
        placeholder: '-- Seleccionar ruta --'
    });
    $('.select2-dias').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#horarioModal'),
        placeholder: 'Seleccionar días...'
    });
});

function openHorarioModal() {
    document.getElementById('horarioId').value = '';
    document.getElementById('horario_horas').value = '';
    document.getElementById('horarioModalTitle').textContent = 'Nuevo Horario';
    $('#horario_ruta_id').val('').trigger('change');
    $('#horario_dias').val([]).trigger('change');
    new bootstrap.Modal(document.getElementById('horarioModal')).show();
}

// Store data for edit
const horariosData = @json($horarios->keyBy('id'));

function editHorario(id) {
    const h = horariosData[id];
    document.getElementById('horarioId').value = h.id;
    document.getElementById('horario_horas').value = h.horarioSalidaTerminal;
    document.getElementById('horario_activo').value = h.activo ? '1' : '0';
    document.getElementById('horarioModalTitle').textContent = 'Editar Horario #' + h.id;
    $('#horario_ruta_id').val(h.ruta_id).trigger('change');
    $('#horario_dias').val(h.dia.split(',')).trigger('change');
    new bootstrap.Modal(document.getElementById('horarioModal')).show();
}

function saveHorario() {
    const id  = document.getElementById('horarioId').value;
    const url = id ? `/admin/horarios/${id}` : '/admin/horarios';
    const dias = $('#horario_dias').val();

    const data = {
        ruta_id:               $('#horario_ruta_id').val(),
        horarioSalidaTerminal: document.getElementById('horario_horas').value,
        dia:                   dias ? dias.join(',') : '',
        activo:                document.getElementById('horario_activo').value,
    };

    $.ajax({
        url, method: id ? 'PUT' : 'POST', data,
        success(res) {
            if (res.success) {
                toastr.success(res.message);
                bootstrap.Modal.getInstance(document.getElementById('horarioModal')).hide();
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

function importCsv() {
    const file = document.getElementById('csvFile').files[0];
    if (!file) { toastr.warning('Selecciona un archivo CSV primero.'); return; }

    const formData = new FormData();
    formData.append('csv_file', file);

    document.getElementById('csvProgress').style.display = 'block';
    document.getElementById('csvResult').style.display = 'none';

    $.ajax({
        url: '{{ route("admin.horarios.importCsv") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success(res) {
            document.getElementById('csvProgress').style.display = 'none';
            let html = `<div class="alert alert-success py-2 px-3" style="font-size:.85rem;border-radius:8px;">
                <strong>${res.imported} horarios importados correctamente.</strong>
            </div>`;
            if (res.errors && res.errors.length) {
                html += `<div class="alert alert-warning py-2 px-3 mt-2" style="font-size:.82rem;border-radius:8px;">
                    <strong>Errores:</strong><br>${res.errors.join('<br>')}
                </div>`;
            }
            document.getElementById('csvResult').innerHTML = html;
            document.getElementById('csvResult').style.display = 'block';
            toastr.success(res.message);
            setTimeout(() => location.reload(), 2000);
        },
        error() {
            document.getElementById('csvProgress').style.display = 'none';
            toastr.error('Error al importar el CSV.');
        }
    });
}

// Open CSV modal
document.querySelector('[onclick*="csvModal"]')?.addEventListener('click', () => {
    new bootstrap.Modal(document.getElementById('csvModal')).show();
});
</script>
@endpush
