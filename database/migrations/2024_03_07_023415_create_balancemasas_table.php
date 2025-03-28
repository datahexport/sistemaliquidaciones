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
        Schema::create('balancemasas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->text('proceso')->nullable();
            $table->text('planta')->nullable();
            $table->text('fecha')->nullable();
            $table->text('rut')->nullable();
            $table->text('productor_recep')->nullable();
            $table->text('variedad')->nullable();
            $table->text('cod_embalaje')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('envases')->nullable();
            $table->text('color')->nullable();
            $table->text('calibre')->nullable();
            $table->text('calibre_real')->nullable();
            $table->text('cantidad')->nullable();
            $table->text('peso_prorrateado')->nullable();
            $table->text('peso_caja')->nullable();
            $table->text('tipo')->nullable();
            $table->text('criterio')->nullable();
            $table->text('color_final')->nullable();
            $table->text('exportadora')->nullable();
            $table->text('norma')->nullable();
            $table->text('semana')->nullable(); 
            $table->text('csg')->nullable(); 
            $table->string('fob')->nullable();
            $table->string('fob_nacional')->nullable();
            $table->string('costo')->nullable();
            $table->string('costo_nacional')->nullable();
            $table->string('margen')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balancemasas');
    }
};
