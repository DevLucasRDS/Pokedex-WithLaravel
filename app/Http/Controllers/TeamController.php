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
        $search = $request->query('name', ''); // pesquisa por nome
        $type = $request->query('type'); // Filtra por tipo

        $validColumns = ['id', 'nome', 'tipo', 'hp', 'attack', 'defense', 'special_attack', 'special_defense', 'speed'];

        $query = Pokemon::query();

        // Filtro de pesquisa
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('id', $search); // aqui id é exato
            });
        }

        if ($type) {
            $query->where('tipo', 'like', "%{$type}%");
        }

        // Ordenação
        if (in_array($sort, $validColumns)) {
            $query->orderBy($sort, $order);
        }

        $pokemons = $query->get();
        return view('teams.teams-create', compact('pokemons', 'sort', 'order', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $trainer = Auth::user()->trainer;

        $team = $trainer->teams()->create([
            'name' => $request->name
        ]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Time criado com sucesso!');
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
