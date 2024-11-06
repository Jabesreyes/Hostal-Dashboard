<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finanzas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clientes_id')->constrained();
            $table->foreignId('habitacions_id')->constrained();
            $table->timestamp('fecha_ingreso');
            $table->timestamp('fecha_retiro');
            $table->foreignId('plataformas_id')->constrained();
            $table->foreignId('metodo_pagos_id')->constrained();
            $table->timestamp('fecha_reserva');
            $table->float('total_pagado',8,2);
            $table->float('precio_dia',8,2);
            $table->foreignId('estado_reservas_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finanzas');
    }
};
