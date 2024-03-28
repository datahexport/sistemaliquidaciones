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

            $table->text('id_check')->nullable();
            $table->text('c_variedad')->nullable();
            $table->text('n_variedad')->nullable();
            $table->text('id_embalaje')->nullable();
            $table->text('c_embalaje')->nullable();
            $table->text('n_embalaje')->nullable();
            $table->text('cp1')->nullable();
            $table->text('cp2')->nullable();
            $table->text('peso_std_embalaje')->nullable();
            $table->text('peso_standard')->nullable();
            $table->text('id_contenedor')->nullable();
            $table->text('c_contenedor')->nullable();
            $table->text('n_contenedor')->nullable();

            $table->text('id_categoria')->nullable();
            $table->text('c_categoria')->nullable();
            $table->text('n_vategoria')->nullable();
            $table->text('t_categoria')->nullable();
            $table->text('id_categoria_st')->nullable();
            $table->text('n_categoria_st')->nullable();
            $table->text('id_calibre')->nullable();
            $table->text('c_calibre')->nullable();
            $table->text('n_calibre')->nullable();
            $table->text('id_serie')->nullable();
            $table->text('c_serie')->nullable();
            $table->text('n_serie')->nullable();

            $table->text('id_etiqueta')->nullable();
            $table->text('c_etiqueta')->nullable();
            $table->text('n_etiqueta')->nullable();
            $table->text('id_plu')->nullable();
            $table->text('c_plu')->nullable();
            $table->text('n_plu')->nullable();
            $table->text('cantidad')->nullable();
            $table->text('peso_neto')->nullable();
            $table->text('id_productor_rotulacion')->nullable();
            $table->text('r_productor_rotulacion')->nullable();
            $table->text('c_productor_rotulacion')->nullable();
            $table->text('n_productor_rotulacion')->nullable();

            $table->text('ns_productor_rotulacion')->nullable();
            $table->text('cp1_productor_rotulacion')->nullable();
            $table->text('id_familia_rotulacion')->nullable();
            $table->text('c_familia_rotulacion')->nullable();
            

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
