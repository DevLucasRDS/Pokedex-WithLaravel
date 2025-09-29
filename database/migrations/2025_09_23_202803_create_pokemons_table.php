<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo');
            $table->integer('altura')->nullable();
            $table->integer('peso')->nullable();
            $table->string('imagem')->nullable();

            // Status em colunas separadas
            $table->integer('hp')->nullable();
            $table->integer('attack')->nullable();
            $table->integer('defense')->nullable();
            $table->integer('special_attack')->nullable();
            $table->integer('special_defense')->nullable();
            $table->integer('speed')->nullable();


            $table->string('habilidades')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon');
    }
};