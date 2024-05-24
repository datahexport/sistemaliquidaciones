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

            $table->text('dest_nombre')->nullable();
            $table->text('fecha')->nullable();
            $table->text('traspaso')->nullable();
            $table->text('folio')->nullable();
            $table->text('CSG')->nullable();
            $table->text('prod_nombre')->nullable();
            $table->text('cli_nombre')->nullable();
            $table->text('Variedad_Real')->nullable();
            $table->text('Variedad_Rotulada')->nullable();
            $table->text('cate_nombre')->nullable();
            $table->text('enva_nombre')->nullable();
            $table->text('fec_emb')->nullable();
            $table->text('eti_nombre')->nullable();
            $table->text('calibre')->nullable();
            $table->text('Cajas')->nullable();
            $table->text('procesor')->nullable();
            $table->text('procesor2')->nullable();
            $table->text('kilos')->nullable();
            $table->text('guiasii')->nullable();
            $table->text('enva_id')->nullable();




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
