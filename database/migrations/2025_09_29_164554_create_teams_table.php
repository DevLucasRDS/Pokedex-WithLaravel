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
            $table->uuid('team_id');
            $table->unsignedBigInteger('pokemon_id'); // supondo que os pokémons sejam numéricos
            $table->tinyInteger('slot'); // 1 até 6
            $table->timestamps();

            $table->primary(['team_id', 'slot']);
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon_team');
        Schema::dropIfExists('teams');
    }
};
