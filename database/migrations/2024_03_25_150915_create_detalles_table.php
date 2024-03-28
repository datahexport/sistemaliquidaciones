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
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');
            
            $table->string('grupo')->nullable();
            $table->string('rut')->nullable();
            $table->string('n_productor')->nullable();
            $table->string('item')->nullable();
            $table->string('fecha')->nullable();
            $table->string('cantidad')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles');
    }
};
