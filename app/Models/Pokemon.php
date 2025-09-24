<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemon';

    protected $fillable = [
        'nome',
        'tipo',
        'altura',
        'peso',
        'imagem',
        'hp',
        'attack',
        'defense',
        'special_attack',
        'special_defense',
        'speed',
        'habilidades',
    ];

    protected $casts = [
        'habilidades' => 'array',
    ];
}
