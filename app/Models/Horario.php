<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    protected $fillable = ['ruta_id', 'horarioSalidaTerminal', 'dia', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function ruta(): BelongsTo
    {
        return $this->belongsTo(Ruta::class, 'ruta_id');
    }

    /**
     * Returns array of hour strings: ['04:30', '05:00', ...]
     */
    public function getHorasArrayAttribute(): array
    {
        return array_map('trim', explode(',', $this->horarioSalidaTerminal));
    }

    /**
     * Returns array of day numbers: [1, 2, 3, 4, 5]
     */
    public function getDiasArrayAttribute(): array
    {
        return array_map('intval', array_map('trim', explode(',', $this->dia)));
    }

    /**
     * Human-readable day label
     */
    public function getDiasLabelAttribute(): string
    {
        $labels = [1 => 'Lun', 2 => 'Mar', 3 => 'Mié', 4 => 'Jue', 5 => 'Vie', 6 => 'Sáb', 7 => 'Dom'];
        $dias = $this->dias_array;

        // Detect common patterns
        if ($dias === [1,2,3,4,5]) return 'Lunes a Viernes';
        if ($dias === [1,2,3,4,5,6]) return 'Lunes a Sábado';
        if ($dias === [1,2,3,4,5,6,7]) return 'Todos los días';
        if ($dias === [6]) return 'Sábados';
        if ($dias === [7]) return 'Domingos';
        if ($dias === [6,7]) return 'Fines de semana';

        return implode(', ', array_map(fn($d) => $labels[$d] ?? $d, $dias));
    }

    /**
     * Next departure from now
     */
    public function getProximaSalidaAttribute(): ?string
    {
        $now = now()->format('H:i');
        foreach ($this->horas_array as $hora) {
            $h = trim($hora);
            if (strlen($h) === 4) $h = '0' . $h; // normalize 4:30 → 04:30
            if ($h >= $now) return $h;
        }
        return null;
    }
}
