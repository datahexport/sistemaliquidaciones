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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->string('productor')->nullable();
            $table->string('fecha')->nullable();
            $table->string('material')->nullable();
            $table->string('cantidad')->nullable();
            $table->string('precio')->nullable();
            $table->string('dolar')->nullable();
            $table->string('orden')->nullable();
            $table->string('busqueda')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
