<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    // Nome da tabela (se não for o plural "pokemons")
    protected $table = 'pokemon';

    // Campos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'nome',
        'tipo',
        'altura',
        'peso',
        'status',
        'habilidades',
        'imagem',
    ];

    // Cast para JSON para poder acessar como array no PHP
    protected $casts = [
        'status' => 'array',
        'habilidades' => 'array',
    ];
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'pokemon_team')
            ->withPivot('slot')
            ->withTimestamps();
    }
}
