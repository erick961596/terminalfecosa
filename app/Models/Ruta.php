<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Ruta extends Model
{
    protected $fillable = ['nombreRuta', 'anden', 'slug', 'meta_description', 'activa'];

    protected $casts = ['activa' => 'boolean'];

    // Auto-generate slug if not provided
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ruta) {
            if (empty($ruta->slug)) {
                $ruta->slug = Str::slug($ruta->nombreRuta);
            }
        });
    }

    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class, 'ruta_id')->where('activo', true);
    }

    public function scopeActivas($query)
    {
        return $query->where('activa', true)->orderBy('nombreRuta');
    }

    /**
     * Get dias as array of day numbers from horarios
     */
    public function getMetaDescriptionDefaultAttribute(): string
    {
        return "Horarios de buses ruta {$this->nombreRuta} – Terminal FECOSA Alajuela. Consulta salidas, andén {$this->anden} y más.";
    }
}
