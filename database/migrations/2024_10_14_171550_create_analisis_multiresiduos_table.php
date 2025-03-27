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
        Schema::create('analisis_multiresiduos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

                $table->string('fecha')->nullable();
                $table->string('orden')->nullable();
                $table->string('precio')->nullable();
                $table->string('uf')->nullable();
                $table->string('total')->nullable();
                $table->string('t_c')->nullable();  // Tipo de cambio
                $table->string('dolar')->nullable();
                $table->string('orden2')->nullable();
                $table->string('productor')->nullable();
                $table->string('busqueda')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_multiresiduos');
    }
};
