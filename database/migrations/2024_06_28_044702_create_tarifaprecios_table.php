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
        Schema::create('tarifaprecios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fob_id')
            ->constrained()
            ->onDelete('cascade');

            $table->foreignId('precio_id')
            ->constrained()
            ->onDelete('cascade');

            $table->string('tarifa')->nullable();
            $table->string('tarifa_fc')->nullable();

            $table->string('suma_fob')->nullable();
            $table->string('suma_fob_fc')->nullable();
            
            $table->string('cant_kg')->nullable();

            $table->text('costo_proceso')->nullable();
            $table->text('costo_materiales')->nullable();
            $table->text('otros_costos')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifaprecios');
    }
};
