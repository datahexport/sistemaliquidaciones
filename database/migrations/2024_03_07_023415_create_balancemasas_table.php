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
        Schema::create('balancemasas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->text('proceso')->nullable();
            $table->text('fecha')->nullable();
            $table->text('csg')->nullable();
            $table->text('productor_recep')->nullable();
            $table->text('variedad')->nullable();
            $table->text('envases')->nullable();
            $table->text('calibre')->nullable();
            $table->text('cantidad')->nullable();
            $table->text('peso_caja')->nullable();
            $table->text('tipo')->nullable();
            $table->text('color_final')->nullable();
            $table->text('semana')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balancemasas');
    }
};
