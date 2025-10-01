<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;

class PokemonControler extends Controller
{
    // Pokédex pública
    public function pokedex(Request $request)
    {
        return $this->fetchPokemons($request, false); // false = não logado
    }

    // Pokédex privada (dashboard)
    public function pokedexDashboard(Request $request)
    {
        return $this->fetchPokemons($request, true); // true = dashboard
    }

    // Função privada que busca os pokémons
    private function fetchPokemons(Request $request, bool $isDashboard)
    {
        $search = $request->query('name'); // pesquisa por nome
        $pokemonId = $request->query('id'); // pesquisa por ID
        $page = $request->query('page', 1);
        $limit = 15;

        $query = Pokemon::query();

        // Filtro por nome
        if ($search) {
            $query->where('nome', 'like', "%{$search}%");
        }

        // Filtro por ID
        if ($pokemonId) {
            $query->where('id', $pokemonId);
        }

        // Paginação
        $pokemons = $query->paginate($limit, ['*'], 'page', $page);

        return view('pokedex.index', [
            'pokemons' => $pokemons,
            'error' => null,
            'page' => $page,
            'isDashboard' => $isDashboard
        ]);
    }

    // Listagem com ordenação
    public function listar(Request $request)
    {
        $sort = $request->query('sort', 'id');
        $order = $request->query('order', 'asc');
        $search = $request->query('name', '');
        $type1 = $request->query('type1');
        $type2 = $request->query('type2');

        $validColumns = ['id', 'nome', 'tipo', 'hp', 'attack', 'defense', 'special_attack', 'special_defense', 'speed'];

        $query = Pokemon::query();

        // Filtro por nome
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }

        // Filtro por tipo 1
        if ($type1) {
            $query->where('tipo', 'like', "%{$type1}%");
        }

        // Filtro por tipo 2
        if ($type2) {
            $query->where('tipo', 'like', "%{$type2}%");
        }

        // Ordenação
        if (in_array($sort, $validColumns)) {
            $query->orderBy($sort, $order);
        }

        $pokemons = $query->get();

        // lista única de tipos para popular o select
        $tipos = [
            'Fire',
            'Water',
            'Grass',
            'Electric',
            'Ice',
            'Fighting',
            'Poison',
            'Ground',
            'Flying',
            'Psychic',
            'Bug',
            'Rock',
            'Ghost',
            'Dragon',
            'Dark',
            'Steel',
            'Fairy'
        ];

        return view('pokedex.listar', compact('pokemons', 'sort', 'order', 'search', 'tipos', 'type1', 'type2'));
    }



    public function especificacao(Request $request)
    {
        $id = $request->query('pokemon'); // pega ?pokemon=1
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            return redirect()->route('pokedex.index')->with('error', 'Pokémon não encontrado');
        }

        return view('pokedex.especificacao', compact('pokemon'));
    }
}
