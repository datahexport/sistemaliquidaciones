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
        Schema::create('temporadas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
            ->nullable()
            ->constrained()
            ->onDelete('set null');

            $table->integer('status')->default(1);

            $table->string('name');
            $table->string('costos_packing')->nullable();
            $table->string('materiales')->nullable();
            $table->string('gastos_de_exportacion')->nullable();
            $table->string('fletes')->nullable();
            $table->string('comision')->nullable();
            $table->string('balance_de_masa')->nullable();
            $table->string('finanzas')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporadas');
    }
};
