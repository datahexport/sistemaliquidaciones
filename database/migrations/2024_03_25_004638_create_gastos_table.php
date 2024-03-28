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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            $table->foreignId('razonsocial_id')
            ->nullable()
            ->constrained()
            ->onDelete('set null');

            $table->foreignId('familia_id')
            ->nullable()
            ->constrained()
            ->onDelete('set null');

            $table->string('item');
            $table->string('categoria')->nullable();
            $table->string('descuenta')->nullable();
            $table->string('status')->nullable();
            $table->string('unidad')->nullable();
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
