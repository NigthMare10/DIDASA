<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('marca', 60);
            $table->string('modelo', 60);
            $table->unsignedSmallInteger('anio');
            $table->string('placa', 20)->unique();
            $table->string('vin', 40)->nullable()->unique();
            $table->unsignedInteger('kilometraje')->default(0);
            $table->string('color', 40);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
