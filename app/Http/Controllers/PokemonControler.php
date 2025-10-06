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
        $sort = $request->query('sort', 'id'); // coluna padrão
        $order = $request->query('order', 'asc'); // direção padrão
        $search = $request->query('name'); // pesquisa por nome
        $type1 = $request->query('type1'); //Filtro por tipo 1
        $type2 = $request->query('type2'); //Filtro por tipo 2

        // Colunas para ordenação
        $validColumns = ['id', 'nome', 'tipo', 'hp', 'attack', 'defense', 'special_attack', 'special_defense', 'speed'];
        // Se a coluna ou ordem não forem válidas, usa os padrões
        $pokemons = Pokemon::query()
            ->when($search, function ($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            })
            ->when($type1, function ($query, $type) {
                $types = is_array($type) ? $type : explode(',', $type);

                $query->where(function ($q) use ($types) {
                    foreach ($types as $t) {
                        $q->orWhere('tipo', 'like', "%{$t}%");
                    }
                });
            })
            ->when($type2, function ($query, $type) {
                $types = is_array($type) ? $type : explode(',', $type);

                $query->where(function ($q) use ($types) {
                    foreach ($types as $t) {
                        $q->orWhere('tipo', 'like', "%{$t}%");
                    }
                });
            })
            ->when(in_array($sort, $validColumns), function ($query) use ($sort, $order) {
                $query->orderBy($sort, $order);
            })
            ->get();
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
        $pokemon = Pokemon::find($id); // Busca o pokemon pelo ID

        if (!$pokemon) {
            return redirect()->route('pokedex.index')->with('error', 'Pokémon não encontrado');
        }

        return view('pokedex.especificacao', compact('pokemon'));
    }
}
