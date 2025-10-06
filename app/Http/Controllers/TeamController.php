<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class TeamController extends Controller
{

    public function index(Request $request)
    {
        $trainer = Auth::user()->trainer;
        $search = $request->query('name', '');

        // começa a query a partir do treinador logado
        $query = $trainer->teams()->with('pokemons');

        if ($search) {
            $query->where('team_name', 'like', "%{$search}%");
        }

        $teams = $query->get();

        return view('teams.teams', compact('teams', 'trainer', 'search'));
    }

    // Reutilizável: busca pokémons a partir dos query params (search, type1, type2, sort, order)
    private function fetchPokemonsFromRequest(Request $request)
    {
        $sort  = $request->query('sort', 'id');
        $order = $request->query('order', 'asc');
        $search = $request->query('name', '');
        $type1 = $request->query('type1');
        $type2 = $request->query('type2');

        $validColumns = ['id', 'nome', 'tipo', 'hp', 'attack', 'defense', 'special_attack', 'special_defense', 'speed'];

        $query = Pokemon::query();
        //Filtros
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }

        if ($type1) {
            $query->where('tipo', 'like', "%{$type1}%");
        }
        if ($type2) {
            $query->where('tipo', 'like', "%{$type2}%");
        }

        if (in_array($sort, $validColumns)) {
            $query->orderBy($sort, $order);
        }

        return $query->get();
    }

    public function create(Request $request)
    {
        $sort   = $request->query('sort', 'id');
        $order  = $request->query('order', 'asc');
        $search = $request->query('name', '');
        $type1  = $request->query('type1');
        $type2  = $request->query('type2');

        $validColumns = ['id', 'nome', 'tipo', 'hp', 'attack', 'defense', 'special_attack', 'special_defense', 'speed'];

        $query = Pokemon::query();
        //Filtros
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }

        if ($type1) {
            $query->where('tipo', 'like', "%{$type1}%");
        }
        if ($type2) {
            $query->where('tipo', 'like', "%{$type2}%");
        }

        if (in_array($sort, $validColumns)) {
            $query->orderBy($sort, $order);
        }

        $pokemons = $query->get();

        // lista simples de tipos (ou busque da DB se preferir)
        $tipos = [
            'Normal',
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

        // Se é AJAX, devolve só a tabela (partial)
        if ($request->ajax()) {
            return view('teams.partials.pokemon-table', compact('pokemons'))->render();
        }

        return view('teams.teams-create', compact('pokemons', 'tipos', 'search', 'type1', 'type2', 'sort', 'order'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'team_pokemons' => 'array|max:6'
        ]);

        $trainer = Auth::user()->trainer;

        $team = $trainer->teams()->create([
            'team_name' => $request->team_name
        ]);

        // Preencher a pivot table com slot
        if ($request->filled('team_pokemons')) {
            $syncData = [];
            foreach ($request->team_pokemons as $slot => $pokemonId) {
                if ($pokemonId) {
                    $syncData[$pokemonId] = ['slot' => $slot];
                }
            }
            $team->pokemons()->sync($syncData);
        }

        return redirect()->route('teams.show', $team)
            ->with('success', 'Time criado com sucesso!');
    }




    public function show(Team $team)
    {
        $this->authorizeTeam($team);

        return view('teams.teams-show', compact('team'));
    }

    public function edit(Team $team, Request $request)
    {
        $pokemons = $this->fetchPokemonsFromRequest($request);

        $tipos = [
            'Normal',
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

        // Ordenar os Pokémon do time pelo slot
        $team->load(['pokemons' => function ($query) {
            $query->orderBy('pivot_slot', 'asc');
        }]);

        return view('teams.teams-edit', [
            'team' => $team,
            'pokemons' => $pokemons,
            'tipos' => $tipos,
            'search' => $request->query('name', ''),
            'type1' => $request->query('type1'),
            'type2' => $request->query('type2'),
            'sort' => $request->query('sort', 'id'),
            'order' => $request->query('order', 'asc'),
        ]);
    }

    public function update(Request $request, Team $team)
    {
        $this->authorizeTeam($team);

        $validated = $request->validate([
            'team_name' => 'required|string|max:255',
            'team_pokemons' => 'array|max:6',
            'team_pokemons.*' => 'nullable|exists:pokemon,id',
        ]);

        // Atualiza nome do time
        $team->update([
            'team_name' => $validated['team_name'],
        ]);

        // Atualiza os pokémons nos slots
        if (isset($validated['team_pokemons'])) {
            $syncData = [];
            foreach ($validated['team_pokemons'] as $slot => $pokemonId) {
                if ($pokemonId) {
                    $syncData[$pokemonId] = ['slot' => $slot];
                }
            }
            $team->pokemons()->sync($syncData);
        }

        return redirect()->route('teams.show', $team)
            ->with('success', 'Time atualizado com sucesso!');
    }


    public function destroy(Team $team)
    {
        $this->authorizeTeam($team);

        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Time deletado com sucesso!');
    }

    private function authorizeTeam(Team $team)
    {
        if ($team->trainer_id !== Auth::user()->trainer->id) {
            abort(403, 'Acesso negado!');
        }
    }
    public function sideBar(Team $team)
    {
        $this->authorizeTeam($team);
    }
}
