<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->id();
            $table->string('nombreRuta', 100);
            $table->integer('anden')->nullable();
            $table->string('slug', 100)->unique();
            $table->text('meta_description')->nullable();
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('rutas'); }
};
