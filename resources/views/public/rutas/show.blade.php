@extends('layouts.public')

@section('title', $ruta->nombreRuta . ' – Terminal FECOSA')
@section('meta_description', $metaDescription)

@section('content')

<!-- RUTA HEADER -->
<div style="background:var(--dark);padding:2rem 1.5rem 1.5rem;border-bottom:3px solid var(--red);">
    <div class="container">
        <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 mb-3 text-decoration-none"
           style="color:rgba(255,255,255,.5);font-size:.85rem;font-weight:600;transition:color .2s;"
           onmouseover="this.style.color='rgba(255,255,255,.9)'" onmouseout="this.style.color='rgba(255,255,255,.5)'">
            <i class="fa-solid fa-arrow-left"></i> Volver a rutas
        </a>

        <div class="d-flex align-items-center gap-4 flex-wrap">
            <div style="background:var(--red);border-radius:12px;padding:1rem 1.4rem;text-align:center;min-width:80px;">
                <div style="font-size:.65rem;font-weight:800;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:1px;">ANDÉN</div>
                <div style="font-family:'Barlow Condensed',sans-serif;font-weight:800;font-size:2.8rem;color:#fff;line-height:1;">
                    {{ $ruta->anden ?? '?' }}
                </div>
            </div>
            <div>
                <h1 style="font-family:'Barlow Condensed',sans-serif;font-weight:800;font-size:clamp(1.6rem,5vw,2.5rem);color:#fff;margin:0;line-height:1.05;">
                    {{ $ruta->nombreRuta }}
                </h1>
                <div style="color:rgba(255,255,255,.5);font-size:.88rem;margin-top:.3rem;">
                    <i class="fa-solid fa-location-dot me-1" style="color:var(--red);"></i>
                    Terminal FECOSA · Alajuela, Costa Rica
                </div>
            </div>
        </div>
    </div>
</div>

<!-- HORARIOS -->
<div class="container py-4">

    @if($ruta->horarios->isEmpty())
        <div class="text-center py-5">
            <i class="fa-solid fa-clock-rotate-left fa-3x mb-3 d-block" style="color:#ddd;"></i>
            <p class="text-muted">No hay horarios registrados para esta ruta.</p>
        </div>
    @else

    @php
    // Group horarios by dias_label
    $grupos = [];
    foreach($ruta->horarios as $h) {
        $label = $h->dias_label;
        if (!isset($grupos[$label])) $grupos[$label] = [];
        $grupos[$label][] = $h;
    }
    @endphp

    <!-- Current time indicator -->
    <div class="d-flex align-items-center gap-2 mb-4 p-3"
         style="background:#f8f8f8;border-radius:10px;font-size:.85rem;color:#666;">
        <i class="fa-regular fa-clock" style="color:#cc1e37;"></i>
        <span>Hora actual: <strong id="currentTime" style="color:#262626;"></strong></span>
        <span class="ms-2" style="background:#fdeaed;color:#cc1e37;font-size:.72rem;font-weight:700;padding:1px 8px;border-radius:4px;">
            Las salidas próximas se resaltan en rojo
        </span>
    </div>

    @foreach($grupos as $diasLabel => $horarioGrupo)
    <div class="mb-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span style="background:var(--dark);color:#fff;font-family:'Barlow Condensed',sans-serif;font-weight:700;font-size:.9rem;padding:4px 14px;border-radius:6px;letter-spacing:.5px;">
                <i class="fa-regular fa-calendar me-1"></i>{{ strtoupper($diasLabel) }}
            </span>
            <div style="flex:1;height:1px;background:#e8e8e8;"></div>
        </div>

        @foreach($horarioGrupo as $horario)
        <div class="mb-3">
            {{-- Hours grid --}}
            <div class="d-flex flex-wrap gap-2" id="grid-{{ $horario->id }}">
                @foreach($horario->horas_array as $hora)
                    @php
                        $h = trim($hora);
                        if (strlen($h) === 4) $h = '0' . $h;
                        // Format to 12h
                        try {
                            $dt = \Carbon\Carbon::createFromFormat('H:i', substr($h,0,5));
                            $formatted = $dt->format('g:i A');
                        } catch(\Exception $e) {
                            $formatted = $h;
                        }
                    @endphp
                    @if($h)
                    <span class="hora-chip-public" data-hora="{{ substr($h,0,5) }}"
                          style="background:#fff;border:1.5px solid #e8e8e8;border-radius:8px;padding:.4rem .75rem;font-family:'Barlow Condensed',sans-serif;font-weight:700;font-size:.95rem;color:#262626;transition:all .2s;display:inline-block;">
                        {{ $formatted }}
                    </span>
                    @endif
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    @endif

    <!-- SEO note -->
    <div class="mt-4 p-3" style="background:#f8f8f8;border-radius:10px;font-size:.8rem;color:#999;">
        <i class="fa-solid fa-circle-info me-1"></i>
        Los horarios pueden cambiar sin previo aviso. Se recomienda confirmar en la terminal.
        Última actualización: {{ $ruta->updated_at->diffForHumans() }}.
    </div>

</div>

@endsection

@push('scripts')
<script>
// Clock
function updateClock() {
    const now = new Date();
    document.getElementById('currentTime').textContent =
        now.toLocaleTimeString('es-CR', {hour:'2-digit', minute:'2-digit'});

    // Highlight próximas salidas (within 30 min)
    const nowMins = now.getHours() * 60 + now.getMinutes();
    document.querySelectorAll('.hora-chip-public[data-hora]').forEach(chip => {
        const [hh, mm] = chip.dataset.hora.split(':').map(Number);
        const chipMins = hh * 60 + mm;
        const diff = chipMins - nowMins;

        chip.style.background = '#fff';
        chip.style.borderColor = '#e8e8e8';
        chip.style.color = '#262626';

        if (diff >= 0 && diff <= 30) {
            chip.style.background = '#fdeaed';
            chip.style.borderColor = '#cc1e37';
            chip.style.color = '#cc1e37';
        } else if (diff < 0) {
            chip.style.opacity = '.45';
        }
    });
}

setInterval(updateClock, 30000);
updateClock();
</script>
@endpush
