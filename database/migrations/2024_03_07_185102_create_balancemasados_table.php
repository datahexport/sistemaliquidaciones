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
        Schema::create('balancemasados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->text('Contenedor')->nullable();
            $table->text('Fecha')->nullable();
            $table->text('Nave')->nullable();
            $table->text('DESTINO')->nullable();
            $table->text('Cliente')->nullable();
            $table->text('Sales_City')->nullable();
            $table->text('Tipo')->nullable();
            $table->text('Total_Venta')->nullable();
            $table->text('Flete_Maritimo_AEREO')->nullable();
            $table->text('Impuestos')->nullable();
            $table->text('Entrada_al_Mercado')->nullable();
            $table->text('Costos_logisticos')->nullable();
            $table->text('Flete_interior')->nullable();
            $table->text('Costos_en_mercado')->nullable();
            $table->text('Ajuste_de_Impuestos')->nullable();
            $table->text('Costo_Extra')->nullable();
            $table->text('REBATE')->nullable();
            $table->text('MAERK')->nullable();
            $table->text('Comisiones')->nullable();
            $table->text('Comision')->nullable();
            $table->text('Costos_Totales')->nullable();
            $table->text('Tipo_de_Cambio')->nullable();
            $table->text('Liq_RMB')->nullable();
            $table->text('Liq_USD')->nullable();
            $table->text('Nuevo_TC')->nullable();
            $table->text('Ajuste_Dif_TC')->nullable();
            $table->text('Liquidacion_USD')->nullable();
            $table->text('TC_FINAL')->nullable();
            $table->text('Cant_Cajas')->nullable();
            $table->text('KG_CONTENEDOR')->nullable();
            $table->text('OTROS_GASTOS')->nullable();
            $table->text('OTROS_COSTOS_SIN_MAERSK')->nullable();
            $table->text('Mes_Facturacion')->nullable();
            $table->text('No_Factura')->nullable();
            $table->text('Otros_Costos')->nullable();
            $table->text('Liq_sin_Maersk')->nullable();
            $table->text('Columna1')->nullable();

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balancemasados');
    }
};
