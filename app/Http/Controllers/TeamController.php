<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class TeamController extends Controller
{

    public function index()
    {
        $trainer = Auth::user()->trainer;
        $teams = $trainer->teams()->with('pokemons')->get();

        return view('teams.teams', compact('teams', 'trainer'));
    }

    public function create(Request $request)
    {
        $sort = $request->query('sort', 'id'); // coluna padrão
        $order = $request->query('order', 'asc'); // direção padrão
        $search = $request->query('name'); // pesquisa por nome
        $type1 = $request->query('type1');
        $type2 = $request->query('type2');

        $validColumns = ['id', 'nome', 'tipo', 'hp', 'attack', 'defense', 'special_attack', 'special_defense', 'speed'];

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

        return view('teams.teams-create', compact('pokemons', 'sort', 'order', 'search', 'tipos', 'type1', 'type2'));
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

        // Salvar os pokémons selecionados, se houver
        if ($request->filled('team_pokemons')) {
            $team->pokemons()->sync(array_filter($request->team_pokemons));
        }

        return redirect()->route('teams.show', $team)
            ->with('success', 'Time criado com sucesso!');;
    }



    public function show(Team $team)
    {
        $this->authorizeTeam($team);

        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $this->authorizeTeam($team);

        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $this->authorizeTeam($team);

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $team->update(['name' => $request->name]);

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
}
