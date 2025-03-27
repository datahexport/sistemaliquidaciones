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
        Schema::create('informes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->foreignId('razonsocial_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->string('informe')->nullable();

            $table->string('nota')->nullable();
            
            $table->string('total_liquidado')->nullable();

            $table->string('oficial')->nullable();
            
            $table->string('diferencia_tipodecambio')->nullable();
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informes');
    }
};
