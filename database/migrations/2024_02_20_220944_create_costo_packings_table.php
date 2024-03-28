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
        Schema::create('costo_packings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->string('cliente')->nullable();
            $table->string('especie')->nullable();
            $table->string('n_productor')->nullable();
            $table->string('csg')->nullable();
            $table->string('kg')->nullable();
            $table->string('total_usd')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costo_packings');
    }
};
