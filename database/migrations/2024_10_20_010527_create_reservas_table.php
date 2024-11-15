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
        Schema::create('reservas', function (Blueprint $table) {
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
            $table->boolean('congelar')->nullable(false);
            $table->boolean('completa')->nullable(false);

         /*   id_cliente int not null,
id_habitacion int not null,
fecha_ingreso date not null,
fecha_retiro date not null,
id_plataforma_reserva int not null,
id_metodo_pago int not null,
fecha_reserva date not null,
total_pagado DECIMAL(10, 2),
id_estado_reserva*/
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
