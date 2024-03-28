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

            $table->text('orden_interno_calibre')->nullable();
            $table->text('c_bodega_origen')->nullable();
            $table->text('n_bodega_origen')->nullable();
            $table->text('numero_trabajores')->nullable();
            $table->text('hora_termino')->nullable();
            $table->text('hora_inicio')->nullable();
            $table->text('horas_efectivas')->nullable();
            $table->text('c_recibidor')->nullable();
            $table->text('r_packing_origen')->nullable();
            $table->text('n_packing_origen')->nullable();
            $table->text('ns_packing_origen')->nullable();
            $table->text('c_packing_origen')->nullable();

            $table->text('nota_calidad')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('kg_aditivos')->nullable();

            $table->text('n_docaditivo')->nullable();
            $table->text('c_aditivo')->nullable();
            $table->text('n_aditivo')->nullable();
            $table->text('referencias')->nullable();

            $table->text('notas')->nullable();
            $table->text('csg')->nullable();
            $table->text('csg_productor')->nullable();
            $table->text('estado')->nullable();
            $table->text('id_marca_etiqueta')->nullable();
            $table->text('c_marca_etiqueta')->nullable();
            $table->text('n_marca_etiqueta')->nullable();
            $table->text('loter_unitec')->nullable();

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
