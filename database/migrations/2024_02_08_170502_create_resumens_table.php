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
        Schema::create('resumens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->string('especie');
            $table->string('variedad');
            $table->string('serie');
            $table->string('color');
            $table->string('cat')->nullable();
            $table->string('cajas')->nullable();
            $table->string('cajas_proceso')->nullable();
            $table->string('kg_salida')->nullable();
            $table->string('total_kg')->nullable();
            $table->string('suma_de_dif')->nullable();
            $table->string('rpn_kg')->nullable();
            $table->string('rpn')->nullable();
            $table->string('rpn_kg2')->nullable();
            $table->string('rpn2')->nullable();
            
            $table->string('suma_ret2')->nullable();
            $table->string('suma_ret2_kg')->nullable();
            
            $table->string('suma_rpn')->nullable();
            
            $table->string('suma_rpn_kg3')->nullable();
            $table->string('suma_rpn3')->nullable();
            $table->string('suma_rpn_kg4')->nullable();
            $table->string('suma_rpn4')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumens');
    }
};
