<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('id')->primary(); // time ainda é UUID
            $table->unsignedBigInteger('trainer_id'); // compatível com trainers.id
            $table->string('team_name');
            $table->timestamps();

            $table->foreign('trainer_id')->references('id')->on('trainers')->onDelete('cascade');
        });


        Schema::create('pokemon_team', function (Blueprint $table) {
            $table->id();
            $table->uuid('team_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedBigInteger('pokemon_id');
            $table->foreign('pokemon_id')->references('id')->on('pokemon')->onDelete('cascade');
            $table->tinyInteger('slot')->nullable(); // opcional, se quiser guardar a posição do Pokémon no time
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon_team');
        Schema::dropIfExists('teams');
    }
};
