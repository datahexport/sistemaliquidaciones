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
        Schema::create('anticipos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');
            
            $table->string('productor')->nullable();        // Columna para el PRODUCTOR
            $table->string('cantidad_usd')->nullable();     // Columna para CANTIDAD USD (string)
            $table->string('usd')->nullable();              // Columna para USD (string)
            $table->string('tipo_cambio')->nullable();      // Columna para TIPO CAMBIO (string)
            $table->string('total')->nullable();            // Columna para TOTAL (string)
            $table->string('fecha')->nullable();            // Columna para FECHA (string)
            $table->string('orden')->nullable();            // Columna para ORDEN (string)
            $table->string('busqueda')->nullable();  // Columna para BUSQUEDA (nullable, string)
            $table->string('incluir')->nullable(); // Columna para INCLUIR? (string, default 'false')
            $table->string('moneda')->nullable();           // Columna para MONEDA (string)
            $table->string('detalle')->nullable(); // Columna para DETALLE (nullable, string)

            $table->string('prorrateado')->nullable(); // Columna para DETALLE (nullable, string)
       

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anticipos');
    }
};
