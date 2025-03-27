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
        Schema::create('ventacomercials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->string('fecha')->nullable(); // Fecha de la venta
            $table->string('cliente')->nullable(); // Nombre del cliente
            $table->string('cantidad_kilos')->nullable(); // Cantidad en Kilos
            $table->string('cajas')->nullable(); // Número de cajas
            $table->string('tipo')->nullable(); // Tipo de venta
            $table->string('descripcion')->nullable(); // Descripción de la venta
            $table->string('precio_unitario')->nullable(); // Precio Unitario
            $table->string('total_iva_incluido')->nullable(); // Total con IVA incluido
            $table->string('condicion_de_pago')->nullable(); // Condición de pago
            $table->string('neto')->nullable(); // Neto
            $table->string('iva')->nullable(); // IVA
            $table->string('tc')->nullable(); // Tipo de cambio (TC)
            $table->string('venta_usd')->nullable(); // Venta en USD
            $table->string('semana')->nullable(); // Semana de la venta

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventacomercials');
    }
};
