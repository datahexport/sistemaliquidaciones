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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            
                $table->string('productor')->nullable();
                $table->string('mes_contabilizacion')->nullable();
                $table->string('tipo_docto')->nullable();
                $table->string('no_docto')->nullable();
                $table->string('monto_neto')->nullable();
                $table->string('iva')->nullable();
                $table->string('total')->nullable();
                $table->string('fecha')->nullable();
                $table->string('orden')->nullable();
                $table->string('busqueda')->nullable();
                $table->string('grupo')->nullable();
                $table->string('fecha_pago')->nullable();
                $table->string('neto')->nullable();
                $table->string('iva2')->nullable();
                $table->string('total2')->nullable();
                $table->string('saldo')->nullable();
                $table->string('tc')->nullable(); // Tasa de cambio
                $table->string('cantidad')->nullable();
                $table->string('usd_kg')->nullable(); // Precio por kilogramo en USD
                $table->string('dolares')->nullable();
                $table->string('valor')->nullable();
                $table->string('total_liq')->nullable();
                $table->string('anticipo')->nullable();
                $table->string('a_pagar')->nullable();
                $table->string('nd')->nullable(); // Nota de débito

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
