<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'trainer_name',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'team_pokemon');
    }
}
