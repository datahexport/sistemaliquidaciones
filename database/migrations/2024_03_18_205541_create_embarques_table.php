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
        Schema::create('embarques', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');
            
            $table->string('t_contenedor')->nullable();
            $table->string('n_destinatario')->nullable();
            $table->string('etd')->nullable();
            $table->string('eta')->nullable();
            $table->string('semana_zarpe')->nullable();
            $table->string('semana_arribo')->nullable();
            $table->string('n_pais_destino')->nullable();
            $table->string('n_embarque')->nullable();
            $table->string('folio')->nullable();
            $table->string('r_productor')->nullable();
            $table->string('c_proveedor')->nullable();
            $table->string('n_productor')->nullable();
            $table->string('booking')->nullable();
            $table->string('n_puerto_origen')->nullable();
            $table->string('n_puerto_destino')->nullable();
            $table->string('n_nave')->nullable();
            $table->string('transporte')->nullable();
            $table->string('fecha_despacho')->nullable();
            $table->string('n_exportadora_embarque')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embarques');
    }
};
