<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruta_id')->constrained('rutas')->onDelete('cascade');
            $table->longText('horarioSalidaTerminal')->comment('Horas separadas por coma: 04:30, 05:00...');
            $table->string('dia', 20)->comment('Días: 1=Lun,2=Mar,3=Mié,4=Jue,5=Vie,6=Sáb,7=Dom. Ej: 1,2,3,4,5');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('horarios'); }
};
