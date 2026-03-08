{{--
    Componente: Botón flotante "Colabora" + Modal de formulario
    Incluir al final del <body> en resources/views/layouts/public.blade.php

    INSTRUCCIÓN: Pegar justo antes del </body> en layouts/public.blade.php:
    @include('components.colabora-modal')
--}}

<!-- ══ BOTÓN FLOTANTE COLABORA ══ -->
<button id="btnColabora" onclick="abrirColabora()"
        aria-label="Colaborar con horarios"
        title="¿Conocés los horarios de alguna ruta?"
        style="
            position:fixed; bottom:24px; right:24px; z-index:9999;
            background:#cc1e37; color:#fff;
            border:none; border-radius:50px;
            padding:.75rem 1.25rem .75rem 1rem;
            display:flex; align-items:center; gap:10px;
            font-family:'Nunito',sans-serif; font-weight:700; font-size:.9rem;
            box-shadow:0 6px 24px rgba(204,30,55,.45);
            cursor:pointer;
            transition:transform .2s, box-shadow .2s;
            animation: pulseBtn 3s infinite;
        "
        onmouseover="this.style.transform='translateY(-3px) scale(1.03)';this.style.boxShadow='0 10px 32px rgba(204,30,55,.55)'"
        onmouseout="this.style.transform='';this.style.boxShadow='0 6px 24px rgba(204,30,55,.45)'">
    <i class="fa-solid fa-bus" style="font-size:1rem;"></i>
    <span class="d-none d-sm-inline">¿Conocés algún horario que no está?</span>
    <span class="d-inline d-sm-none">Colaborar</span>
</button>

<!-- ══ MODAL COLABORA ══ -->
<div id="colaboraModal"
     style="display:none;position:fixed;inset:0;z-index:10000;padding:1rem;
            background:rgba(0,0,0,.65);backdrop-filter:blur(4px);
            align-items:center;justify-content:center;overflow-y:auto;"
     onclick="cerrarColaboraFuera(event)">

    <div style="background:#fff;border-radius:20px;width:100%;max-width:560px;
                margin:auto;overflow:hidden;
                box-shadow:0 20px 60px rgba(0,0,0,.3);
                animation:slideUp .25s ease;"
         id="colaboraCard">

        <!-- Header del modal -->
        <div style="background:#262626;padding:1.4rem 1.5rem;border-bottom:3px solid #cc1e37;position:relative;">
            <div style="font-family:'Barlow Condensed',sans-serif;font-weight:800;font-size:1.3rem;color:#fff;line-height:1;">
                <i class="fa-solid fa-people-group me-2" style="color:#cc1e37;"></i>
                COLABORÁ CON TU COMUNIDAD
            </div>
            <div style="font-size:.75rem;color:rgba(255,255,255,.5);margin-top:4px;font-weight:600;letter-spacing:.5px;">
                ¿Conocés los horarios de alguna ruta? ¡Ayudanos a completarlos!
            </div>
            <button onclick="cerrarColabora()"
                    style="position:absolute;top:1rem;right:1rem;background:rgba(255,255,255,.1);
                           border:none;border-radius:8px;color:#fff;width:32px;height:32px;
                           cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;
                           transition:background .2s;"
                    onmouseover="this.style.background='rgba(255,255,255,.2)'"
                    onmouseout="this.style.background='rgba(255,255,255,.1)'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Disclaimer comunitario -->
        <div style="background:#fffbeb;border-bottom:1px solid #fde68a;padding:.75rem 1.5rem;
                    display:flex;align-items:flex-start;gap:.6rem;">
            <i class="fa-solid fa-circle-info" style="color:#d97706;margin-top:2px;flex-shrink:0;"></i>
            <p style="margin:0;font-size:.78rem;color:#92400e;line-height:1.5;">
                <strong>Servicio comunitario voluntario.</strong> Este formulario
                <strong>no es oficial</strong> de la Municipalidad de Alajuela ni de FECOSA.
                La información enviada será revisada antes de publicarse.
            </p>
        </div>

        <!-- Formulario -->
        <div style="padding:1.5rem;" id="colaboraFormWrapper">
            <form id="colaboraForm" enctype="multipart/form-data" onsubmit="enviarColabora(event)">
                @csrf

                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#444;margin-bottom:5px;">
                        Tu nombre <span style="color:#999;font-weight:400;">(opcional)</span>
                    </label>
                    <input type="text" name="nombre" maxlength="100" placeholder="Ej: María Rodríguez"
                           style="width:100%;border:1.5px solid #e0e0e0;border-radius:9px;padding:.6rem .9rem;
                                  font-family:'Nunito',sans-serif;font-size:.9rem;color:#262626;
                                  transition:border-color .2s;outline:none;"
                           onfocus="this.style.borderColor='#cc1e37'" onblur="this.style.borderColor='#e0e0e0'">
                </div>

                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#444;margin-bottom:5px;">
                        ¿De qué ruta conocés los horarios? <span style="color:#cc1e37;">*</span>
                    </label>
                    <input type="text" name="ruta" required maxlength="150"
                           placeholder="Ej: Cacao, Atenas, Carrizal, Canoas-Guadalupe..."
                           style="width:100%;border:1.5px solid #e0e0e0;border-radius:9px;padding:.6rem .9rem;
                                  font-family:'Nunito',sans-serif;font-size:.9rem;color:#262626;
                                  transition:border-color .2s;outline:none;"
                           onfocus="this.style.borderColor='#cc1e37'" onblur="this.style.borderColor='#e0e0e0'">
                </div>

                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#444;margin-bottom:5px;">
                        Horarios que conocés <span style="color:#cc1e37;">*</span>
                    </label>
                    <textarea name="horarios" required maxlength="2000" rows="4"
                              placeholder="Ej:&#10;Lunes a viernes: 05:00, 06:30, 08:00, 10:00...&#10;Sábados: 07:00, 09:00, 12:00..."
                              style="width:100%;border:1.5px solid #e0e0e0;border-radius:9px;padding:.6rem .9rem;
                                     font-family:'Nunito',sans-serif;font-size:.9rem;color:#262626;resize:vertical;
                                     transition:border-color .2s;outline:none;"
                              onfocus="this.style.borderColor='#cc1e37'" onblur="this.style.borderColor='#e0e0e0'"></textarea>
                </div>

                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#444;margin-bottom:5px;">
                        Comentarios adicionales <span style="color:#999;font-weight:400;">(opcional)</span>
                    </label>
                    <textarea name="comentario" maxlength="1000" rows="2"
                              placeholder="Ej: Los sábados sale más temprano, el último bus es a las 10pm..."
                              style="width:100%;border:1.5px solid #e0e0e0;border-radius:9px;padding:.6rem .9rem;
                                     font-family:'Nunito',sans-serif;font-size:.9rem;color:#262626;resize:vertical;
                                     transition:border-color .2s;outline:none;"
                              onfocus="this.style.borderColor='#cc1e37'" onblur="this.style.borderColor='#e0e0e0'"></textarea>
                </div>

                <!-- File upload -->
                <div style="margin-bottom:1.25rem;">
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#444;margin-bottom:5px;">
                        Adjuntar evidencia <span style="color:#999;font-weight:400;">(foto, PDF o Excel – máx. 5MB)</span>
                    </label>
                    <label id="fileDropZone"
                           style="display:flex;flex-direction:column;align-items:center;justify-content:center;
                                  border:2px dashed #e0e0e0;border-radius:10px;padding:1.2rem;
                                  cursor:pointer;transition:all .2s;background:#fafafa;gap:6px;"
                           onmouseover="this.style.borderColor='#cc1e37';this.style.background='#fdeaed'"
                           onmouseout="this.style.borderColor='#e0e0e0';this.style.background='#fafafa'"
                           ondragover="dragOver(event)" ondragleave="dragLeave(event)" ondrop="dropFile(event)">
                        <i class="fa-solid fa-cloud-arrow-up" style="font-size:1.5rem;color:#999;"></i>
                        <span style="font-size:.82rem;color:#666;font-weight:600;">
                            Arrastrá o hacé clic para adjuntar
                        </span>
                        <span style="font-size:.72rem;color:#aaa;">JPG, PNG, PDF, XLSX · máx. 5MB</span>
                        <input type="file" name="adjunto" id="adjuntoInput" accept=".jpg,.jpeg,.png,.pdf,.xlsx,.xls"
                               style="display:none;" onchange="mostrarArchivo(this)">
                    </label>
                    <div id="filePreview" style="display:none;margin-top:.5rem;background:#f0fdf4;
                                                  border-radius:8px;padding:.5rem .9rem;
                                                  display:none;align-items:center;gap:.6rem;">
                        <i class="fa-solid fa-file-circle-check" style="color:#16a34a;"></i>
                        <span id="fileName" style="font-size:.82rem;color:#16a34a;font-weight:600;flex:1;"></span>
                        <button type="button" onclick="quitarArchivo()"
                                style="background:none;border:none;color:#999;cursor:pointer;font-size:.85rem;"
                                title="Quitar archivo">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>

                <!-- Error messages -->
                <div id="colaboraErrors" style="display:none;background:#fdeaed;border-radius:8px;
                                                  padding:.6rem 1rem;margin-bottom:1rem;font-size:.82rem;color:#cc1e37;">
                </div>

                <!-- Submit -->
                <button type="submit" id="btnEnviar"
                        style="width:100%;background:#cc1e37;color:#fff;border:none;border-radius:10px;
                               padding:.75rem;font-family:'Nunito',sans-serif;font-weight:700;font-size:1rem;
                               cursor:pointer;transition:background .2s,transform .15s;
                               display:flex;align-items:center;justify-content:center;gap:.6rem;"
                        onmouseover="this.style.background='#a3152b'" onmouseout="this.style.background='#cc1e37'">
                    <i class="fa-solid fa-paper-plane"></i>
                    Enviar mi colaboración
                </button>

            </form>
        </div>

        <!-- Estado: Enviando -->
        <div id="colaboraLoading" style="display:none;padding:2.5rem 1.5rem;text-align:center;">
            <div style="width:48px;height:48px;border:4px solid #f0f0f0;border-top-color:#cc1e37;
                        border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 1rem;"></div>
            <p style="margin:0;font-weight:700;color:#444;">Enviando tu colaboración…</p>
        </div>

        <!-- Estado: Éxito -->
        <div id="colaboraSuccess" style="display:none;padding:2.5rem 1.5rem;text-align:center;">
            <div style="width:64px;height:64px;background:#f0fdf4;border-radius:50%;
                        display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <i class="fa-solid fa-circle-check" style="font-size:2rem;color:#16a34a;"></i>
            </div>
            <h3 style="font-family:'Barlow Condensed',sans-serif;font-weight:800;font-size:1.5rem;
                       color:#262626;margin:0 0 .5rem;">¡Muchas gracias!</h3>
            <p style="color:#666;font-size:.9rem;margin:0 0 1.5rem;line-height:1.6;">
                Tu colaboración fue enviada con éxito.<br>
                Revisaremos la información y la publicaremos si está correcta.
            </p>
            <button onclick="cerrarColabora()"
                    style="background:#262626;color:#fff;border:none;border-radius:10px;
                           padding:.6rem 1.5rem;font-weight:700;cursor:pointer;font-size:.9rem;">
                Cerrar
            </button>
        </div>

    </div>
</div>

<!-- Estilos y JS del módulo -->
<style>
@keyframes pulseBtn {
    0%,100% { box-shadow: 0 6px 24px rgba(204,30,55,.45); }
    50%      { box-shadow: 0 6px 32px rgba(204,30,55,.7); }
}
@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<script>
function abrirColabora() {
    const modal = document.getElementById('colaboraModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    // Reset states
    document.getElementById('colaboraFormWrapper').style.display = 'block';
    document.getElementById('colaboraLoading').style.display = 'none';
    document.getElementById('colaboraSuccess').style.display = 'none';
    document.getElementById('colaboraErrors').style.display = 'none';
    document.getElementById('colaboraForm').reset();
    quitarArchivo();


    // ── Google Analytics event ──
    gtag('event', 'open_colabora_modal', {
        event_category: 'Colaboracion',
        event_label:    'Boton flotante colaborar',
    });


}

function cerrarColabora() {
    document.getElementById('colaboraModal').style.display = 'none';
    document.body.style.overflow = '';
}

function cerrarColaboraFuera(e) {
    if (e.target === document.getElementById('colaboraModal')) cerrarColabora();
}

// File handling
function mostrarArchivo(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById('fileName').textContent = file.name + ' (' + (file.size/1024/1024).toFixed(2) + ' MB)';
        document.getElementById('filePreview').style.display = 'flex';
    }
}

function quitarArchivo() {
    document.getElementById('adjuntoInput').value = '';
    document.getElementById('filePreview').style.display = 'none';
    document.getElementById('fileName').textContent = '';
}

function dragOver(e) {
    e.preventDefault();
    e.currentTarget.style.borderColor = '#cc1e37';
    e.currentTarget.style.background = '#fdeaed';
}
function dragLeave(e) {
    e.currentTarget.style.borderColor = '#e0e0e0';
    e.currentTarget.style.background = '#fafafa';
}
function dropFile(e) {
    e.preventDefault();
    dragLeave(e);
    const file = e.dataTransfer.files[0];
    if (file) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('adjuntoInput').files = dt.files;
        mostrarArchivo(document.getElementById('adjuntoInput'));
    }
}

// Submit via AJAX
function enviarColabora(e) {
    e.preventDefault();
    const form = document.getElementById('colaboraForm');
    const formData = new FormData(form);

    document.getElementById('colaboraFormWrapper').style.display = 'none';
    document.getElementById('colaboraLoading').style.display = 'block';
    document.getElementById('colaboraErrors').style.display = 'none';

    fetch('/colabora', {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('colaboraLoading').style.display = 'none';
        if (data.success) {
            document.getElementById('colaboraSuccess').style.display = 'block';

            if (data.success) {
                // ── GA: envío exitoso ──
                gtag('event', 'submit_colaboracion', {
                    event_category: 'Colaboracion',
                    event_label:    'Formulario enviado con éxito',
                });
                document.getElementById('colaboraSuccess').style.display = 'block';
            }


        } else {
            document.getElementById('colaboraFormWrapper').style.display = 'block';
            mostrarErrores(data.errors || {general: [data.message || 'Error al enviar.']});
        }
    })
    .catch(() => {
        document.getElementById('colaboraLoading').style.display = 'none';
        document.getElementById('colaboraFormWrapper').style.display = 'block';
        mostrarErrores({general: ['Error de conexión. Intentá de nuevo.']});
    });
}

function mostrarErrores(errors) {
    const el = document.getElementById('colaboraErrors');
    const msgs = Object.values(errors).flat();
    el.innerHTML = '<i class="fa-solid fa-circle-exclamation me-1"></i>' + msgs.join('<br>');
    el.style.display = 'block';
}

// ESC key closes modal
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') cerrarColabora();
});
</script>
