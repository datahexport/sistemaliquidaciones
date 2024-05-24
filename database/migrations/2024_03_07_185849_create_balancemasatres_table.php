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

            $table->text('Temporada')->nullable();
            $table->text('Estado')->nullable();
            $table->text('Packing')->nullable();
            $table->text('Folio')->nullable();
            $table->text('N_GuiaSII_Rec')->nullable();
            $table->text('N_lote')->nullable();
            $table->text('Peido')->nullable();
            $table->text('Fecha_Emb')->nullable();
            $table->text('Cliente')->nullable();
            $table->text('CSG')->nullable();
            $table->text('Csg_Rot')->nullable();
            $table->text('Nombre_Huerto')->nullable();
            $table->text('Nombre_CSG_Rot')->nullable();
            $table->text('Nombre_Productor')->nullable();
            $table->text('Etiqueta')->nullable();
            $table->text('C_Envase')->nullable();
            $table->text('Envase')->nullable();
            $table->text('Especie')->nullable();
            $table->text('Variedad_Real')->nullable();
            $table->text('Variedad_Rot')->nullable();
            $table->text('Categoria')->nullable();
            $table->text('Calidad')->nullable();
            $table->text('Calibre')->nullable();
            $table->text('Cajas_INICIAL')->nullable();
            $table->text('Dif_Cajas')->nullable();
            $table->text('Cajas')->nullable();
            $table->text('Cajas_Pallet')->nullable();
            $table->text('Kilos_INICIAL')->nullable();
            $table->text('Dif_Kilos_proc')->nullable();
            $table->text('Kilos_prod')->nullable();
            $table->text('Kilos_emb')->nullable();
            $table->text('Proceso')->nullable();
            $table->text('Tipo_Pallet')->nullable();
            $table->text('Base_Pallet')->nullable();
            $table->text('Altura')->nullable();
            $table->text('C_Packing')->nullable();
            $table->text('C_Variedad_real')->nullable();
            $table->text('C_Variedad_Rot')->nullable();
            $table->text('C_Categoria')->nullable();
            $table->text('C_Cliente')->nullable();
            $table->text('C_Etiqueta')->nullable();
            $table->text('C_Especie')->nullable();
            $table->text('C_Recibidor')->nullable();
            $table->text('C_Mercado')->nullable();
            $table->text('Nave')->nullable();
            $table->text('Fecha_Salida')->nullable();
            $table->text('Exportador')->nullable();
            $table->text('Mercado')->nullable();
            $table->text('Despacho')->nullable();
            $table->text('Folio_Sag')->nullable();
            $table->text('Fecha_despacho')->nullable();
            $table->text('Recibidor_comprador')->nullable();
            $table->text('Numero_Inspeccion')->nullable();
            $table->text('Fecha_Inspeccion')->nullable();
            $table->text('Estado_Inspeccion')->nullable();
            $table->text('Guia_sii')->nullable();
            $table->text('Contenedor')->nullable();
            $table->text('Peso_Neto')->nullable();
            $table->text('Peso_Bruto')->nullable();
            $table->text('Fecha_Digitacion')->nullable();
            $table->text('N_Reserva')->nullable();
            $table->text('Fecha_Reserva')->nullable();
            $table->text('Planta')->nullable();
            $table->text('Planta_Despacho')->nullable();
            
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
