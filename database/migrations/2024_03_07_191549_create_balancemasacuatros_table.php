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
        Schema::create('balancemasacuatros', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->text('Sales_date')->nullable();
            $table->text('Arrival_Date')->nullable();
            $table->text('N_Pallet')->nullable();
            $table->text('Variedad')->nullable();
            $table->text('Etiqueta')->nullable();
            $table->text('Calibre_y_Color')->nullable();
            $table->text('Cajas')->nullable();
            $table->text('Precio_Venta_Yen')->nullable();
            $table->text('Total_Venta')->nullable();
            $table->text('Contenedor')->nullable();
            $table->text('PESO_TOTAL')->nullable();
            $table->text('CAJAS_DESPACHADAS')->nullable();
            $table->text('DIF')->nullable();
            $table->text('PESO_CAJA')->nullable();
            $table->text('COLOR')->nullable();
            $table->text('SIG_COLOR')->nullable();
            $table->text('CALIBRE')->nullable();
            $table->text('TC')->nullable();
            $table->text('VENTA_USD')->nullable();
            $table->text('COMISION')->nullable();
            $table->text('FLETE')->nullable();
            $table->text('OTROS_GASTOS')->nullable();
            $table->text('Apoyo_Liquidaciones')->nullable();
            $table->text('LIQ_CLIENTE')->nullable();
            $table->text('PROMOCION_ASOEX')->nullable();
            $table->text('SEGURO_CARGA')->nullable();
            $table->text('LIQ_PRODUCTOR')->nullable();
            $table->text('RETORNO_PRODUCTOR_ESTIMADO')->nullable();
            $table->text('NAVE')->nullable();
            $table->text('CLIENTE')->nullable();
            $table->text('PAIS')->nullable();
            $table->text('MERCADO')->nullable();
            $table->text('UNIR_CADE')->nullable();


            $table->text('id_check')->nullable();
          

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balancemasacuatros');
    }
};
