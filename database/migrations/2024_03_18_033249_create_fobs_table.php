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
        Schema::create('fobs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');
            
            $table->string('n_variedad')->nullable();
            $table->string('semana')->nullable();
            $table->string('etiqueta')->nullable();
            $table->string('n_calibre')->nullable();
            $table->string('color')->nullable();
            $table->string('categoria')->nullable();
            $table->string('fob_kilo_salida')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fobs');
    }
};
