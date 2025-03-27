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
        Schema::create('modificacions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('informe_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->string('categoria')->nullable();
            $table->string('variedad')->nullable();
            $table->string('calibre')->nullable();
            $table->string('retorno_inicial')->nullable();
            $table->string('retorno')->nullable();
            $table->string('npk')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modificacions');
    }
};
