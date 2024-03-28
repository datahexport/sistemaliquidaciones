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
        Schema::create('balancemasatres', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->text('id_check')->nullable();
            $table->text('n_familia_rotulacion')->nullable();
            $table->text('id_especie_rotulacion')->nullable();
            $table->text('c_especie_rotulacion')->nullable();
            $table->text('n_especie_rotulacion')->nullable();

            $table->text('id_variedad_rotulacion')->nullable();
            $table->text('c_variedad_rotulacion')->nullable();
            $table->text('n_variedad_rotulacion')->nullable();
            $table->text('id_empresa')->nullable();

            $table->text('ngd_recepcion')->nullable();
            $table->text('fecha_documento')->nullable();
            $table->text('fecha_documento_sh')->nullable();
            $table->text('id_linea_proceso')->nullable();
            $table->text('c_linea_proceso')->nullable();
            $table->text('n_linea_proceso')->nullable();
            $table->text('numero_gruia_recepcion')->nullable();
            $table->text('fecha_recepcion')->nullable();

            $table->text('id_turno')->nullable();
            $table->text('n_turno')->nullable();
            $table->text('id_tipo_proceso')->nullable();
            $table->text('n_tipo_proceso')->nullable();
            $table->text('id_condicion')->nullable();
            $table->text('c_condicion')->nullable();
            $table->text('n_condicion')->nullable();

            $table->text('id_grupo_proceso')->nullable();
            $table->text('c_grupo_proceso')->nullable();
            $table->text('n_grupo_proceso')->nullable();
            $table->text('peso_equivalente')->nullable();
            $table->text('id_cliente_packing')->nullable();
            $table->text('r_cliente_packing')->nullable();
            $table->text('c_cliente_packing')->nullable();
            $table->text('n_cliente_packing')->nullable();

            $table->text('fecha_cosecha_sf')->nullable();
            $table->text('fecha_produccion_sf')->nullable();
            $table->text('ngi_recepcion')->nullable();
            $table->text('creacion_tipo')->nullable();
            $table->text('c_marca')->nullable();
            $table->text('n_marca')->nullable();
            $table->text('id_variedad_comercial')->nullable();
            $table->text('c_variedad_comercial')->nullable();
            $table->text('n_variedad_comercial')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balancemasatres');
    }
};
