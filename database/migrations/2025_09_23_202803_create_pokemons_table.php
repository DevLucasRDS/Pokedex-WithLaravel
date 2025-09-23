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
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo')->nullable();
            $table->integer('altura')->nullable();
            $table->integer('peso')->nullable();
            $table->json('status')->nullable(); // hp, attack, defense, etc.
            $table->json('habilidades')->nullable(); // habilidades
            $table->string('imagem')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemons');
    }
};
