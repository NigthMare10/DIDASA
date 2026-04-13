<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('niveles_fidelidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->string('slug', 80)->unique();
            $table->unsignedInteger('puntos_minimos')->default(0);
            $table->unsignedTinyInteger('descuento_porcentaje')->default(0);
            $table->string('color', 20)->nullable();
            $table->string('icono', 40)->nullable();
            $table->unsignedSmallInteger('orden')->default(1);
            $table->timestamps();
        });

        Schema::create('movimientos_puntos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tipo', 20);
            $table->string('descripcion', 150);
            $table->integer('puntos');
            $table->integer('saldo_resultante')->default(0);
            $table->string('origen_tipo', 60)->nullable();
            $table->unsignedBigInteger('origen_id')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });

        Schema::create('insignias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->string('descripcion', 150);
            $table->string('criterio', 120);
            $table->string('icono', 40)->nullable();
            $table->unsignedSmallInteger('orden')->default(1);
            $table->timestamps();
        });

        Schema::create('usuario_insignia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('insignia_id')->constrained('insignias')->cascadeOnDelete();
            $table->timestamp('obtenida_en')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'insignia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_insignia');
        Schema::dropIfExists('insignias');
        Schema::dropIfExists('movimientos_puntos');
        Schema::dropIfExists('niveles_fidelidad');
    }
};
