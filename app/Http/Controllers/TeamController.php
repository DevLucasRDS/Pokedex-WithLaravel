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

        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create');
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
