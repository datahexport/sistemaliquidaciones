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
        Schema::create('ajustecostos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');
            
            $table->string('n_variedad')->nullable();
            $table->string('semana')->nullable();
            $table->string('n_calibre')->nullable();

            $table->string('suma_caja_diferencial_22')->nullable();
            $table->string('peso_caja_diferencial_22')->nullable();
 
            $table->string('suma_caja_diferencial_25')->nullable();
            $table->string('peso_caja_diferencial_25')->nullable();

            $table->string('suma_caja_diferencial_5')->nullable();
            $table->string('peso_caja_diferencial_5')->nullable();

            $table->string('suma_caja_diferencial_10')->nullable();
            $table->string('peso_caja_diferencial_10')->nullable();

            $table->string('suma_caja_diferencial_com')->nullable();
            $table->string('peso_caja_diferencial_com')->nullable();

           
            $table->string('suma_caja_diferencial_total')->nullable();
            $table->string('peso_caja_diferencial_total')->nullable();

            $table->string('tarifa_costo')->nullable();
          

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustecostos');
    }
};
