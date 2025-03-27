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
        Schema::create('procesos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');
            
            $table->text('PROCESO')->nullable();
            $table->text('TURNO')->nullable();
            $table->text('PLANTA')->nullable();
            $table->text('FECHA')->nullable();
            $table->text('PRODUCTOR_RECEP_FACTURACION')->nullable();
            $table->text('VARIEDAD')->nullable();
            $table->text('ENVASES_ETIQ')->nullable();
            $table->text('COLOR')->nullable();
            $table->text('CALIBRE')->nullable();
            $table->text('CALIBRE_REAL')->nullable();
            $table->text('CANT')->nullable();
            $table->text('PESO_FINAL')->nullable();
            $table->text('PESO_PRORRATEADO')->nullable();
            $table->text('KG_VACIADO')->nullable();
            $table->text('PESO_CAJA')->nullable();
            $table->text('TIPO_CAJA')->nullable();
            $table->text('CAJA_EQ_5KG')->nullable();
            $table->text('TIPO')->nullable();
            $table->text('CRITERIO')->nullable();
            $table->text('COLOR_FINAL')->nullable();
            $table->text('BUSQUEDA_PROCESO')->nullable();
            $table->text('EXPORTADORA')->nullable();
            $table->text('NORMA')->nullable();
            $table->text('SEMANA')->nullable();

            $table->text('costo_proceso')->nullable();
            $table->text('costo_materiales')->nullable();
            $table->text('otros_costos')->nullable();

            $table->text('costo')->nullable();

            $table->text('gastos')->nullable();
            $table->text('anticipos')->nullable();

            $table->text('fob_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procesos');
    }
};
