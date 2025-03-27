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
        Schema::create('fobdespachos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temporada_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');
            
            $table->string('folio')->nullable();
            
            $table->string('bruto')->nullable();
            $table->string('comision')->nullable();
            $table->string('flete')->nullable();
            $table->string('otros')->nullable();
            $table->string('apoyo')->nullable();
            $table->string('variedad')->nullable();
            $table->string('calibre_color')->nullable();


            $table->string('suma_fob')->nullable();
            $table->string('cant_kg')->nullable();
            $table->string('fob_kilo_salida')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fobdespachos');
    }
};
