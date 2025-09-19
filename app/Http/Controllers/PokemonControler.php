<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonControler extends Controller
{
    public function index(Request $request)
    {
        // Recebe o nome do Pokémon da query string (ex: ?name=pikachu)
        $name = $request->query('name', 'pikachu'); // Default: pikachu

        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$name}");

        if ($response->failed()) {
            return view('pokemon.index', [
                'error' => 'Pokémon não encontrado!',
                'pokemons' => [],
            ]);
        }

        $pokemon = $response->json();

        $data = [
            [
                'nome' => ucfirst($pokemon['name']),
                'altura' => $pokemon['height'],
                'peso' => $pokemon['weight'],
                'habilidades' => array_map(fn($h) => $h['ability']['name'], $pokemon['abilities']),
                'imagem' => $pokemon['sprites']['front_default'],
                'tipo' => implode(', ', array_map(fn($t) => $t['type']['name'], $pokemon['types'])),
            ]
        ];

        return view('pokemon.index', [
            'pokemons' => $data,
            'error' => null,
        ]);
    }
}
