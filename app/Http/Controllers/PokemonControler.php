<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonControler extends Controller
{
    // Pokedex pública
    public function pokedex(Request $request)
    {
        return $this->fetchPokemons($request, false); // false = não é dashboard
    }

    // Pokedex privada (dashboard)
    public function pokedexDashboard(Request $request)
    {
        return $this->fetchPokemons($request, true); // true = dashboard
    }

    // Função privada que busca os pokémons
    private function fetchPokemons(Request $request, bool $isDashboard)
    {
        $name = $request->query('name'); // pesquisa por nome
        $pokemonId = $request->query('id'); // pesquisa por ID
        $page = $request->query('page', 1);
        $limit = 15;
        $offset = ($page - 1) * $limit;

        $pokemons = [];
        $error = null;

        // Se pesquisou por nome ou ID, traz só 1 Pokémon
        if ($name || $pokemonId) {
            $search = $name ?? $pokemonId;
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$search}");

            if ($response->failed()) {
                $error = 'Pokémon não encontrado!';
            } else {
                $pokemon = $response->json();
                $pokemons[] = [
                    'id' => $pokemon['id'],
                    'nome' => ucfirst($pokemon['name']),
                    'imagem' => $pokemon['sprites']['front_default'] ?? 'https://via.placeholder.com/96x96?text=?',
                    'tipo' => implode(', ', array_map(fn($t) => $t['type']['name'], $pokemon['types']))
                ];
            }
        } else {
            // Lista 15 por página
            $response = Http::get("https://pokeapi.co/api/v2/pokemon?limit={$limit}&offset={$offset}");
            if ($response->failed()) {
                $error = 'Erro ao buscar Pokémons!';
            } else {
                foreach ($response->json()['results'] as $result) {
                    $pokeData = Http::get($result['url'])->json();
                    $pokemons[] = [
                        'id' => $pokeData['id'],
                        'nome' => ucfirst($pokeData['name']),
                        'imagem' => $pokeData['sprites']['front_default'] ?? 'https://via.placeholder.com/96x96?text=?',
                        'tipo' => implode(', ', array_map(fn($t) => $t['type']['name'], $pokeData['types']))
                    ];
                }
            }
        }

        // Retorna a view com a variável isDashboard para mostrar funções extras
        return view('pokedex.index', [
            'pokemons' => $pokemons,
            'error' => $error,
            'page' => $page,
            'isDashboard' => $isDashboard
        ]);
    }
}
