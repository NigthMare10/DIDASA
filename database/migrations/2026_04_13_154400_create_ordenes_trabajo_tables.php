<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_trabajo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->cascadeOnDelete();
            $table->foreignId('cita_id')->nullable()->constrained('citas')->nullOnDelete();
            $table->string('numero_orden', 30)->unique();
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();
            $table->string('estado', 30)->default('agendada');
            $table->unsignedTinyInteger('progreso')->default(0);
            $table->date('fecha_ingreso');
            $table->date('fecha_estimada')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->decimal('total_estimado', 10, 2)->default(0);
            $table->timestamps();

            $table->index(['user_id', 'estado']);
        });

        Schema::create('orden_trabajo_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_trabajo_id')->constrained('ordenes_trabajo')->cascadeOnDelete();
            $table->string('titulo', 120);
            $table->string('descripcion', 190)->nullable();
            $table->string('estado_etapa', 40)->nullable();
            $table->unsignedSmallInteger('orden')->default(1);
            $table->boolean('completado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_trabajo_eventos');
        Schema::dropIfExists('ordenes_trabajo');
    }
};
