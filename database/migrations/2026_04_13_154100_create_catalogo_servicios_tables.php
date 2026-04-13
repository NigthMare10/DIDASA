<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias_servicio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->string('slug', 80)->unique();
            $table->string('icono', 40)->nullable();
            $table->string('descripcion')->nullable();
            $table->unsignedSmallInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_servicio_id')->nullable()->constrained('categorias_servicio')->nullOnDelete();
            $table->string('nombre', 120);
            $table->string('slug', 120)->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('precio_base', 10, 2);
            $table->unsignedSmallInteger('duracion_minutos')->default(60);
            $table->boolean('visible_catalogo')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index(['categoria_servicio_id', 'activo']);
            $table->index(['visible_catalogo', 'activo']);
        });

        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('slug', 120)->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('precio_base', 10, 2);
            $table->boolean('visible_catalogo')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index(['visible_catalogo', 'activo']);
        });

        Schema::create('paquete_servicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paquete_id')->constrained('paquetes')->cascadeOnDelete();
            $table->foreignId('servicio_id')->constrained('servicios')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['paquete_id', 'servicio_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paquete_servicio');
        Schema::dropIfExists('paquetes');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('categorias_servicio');
    }
};
