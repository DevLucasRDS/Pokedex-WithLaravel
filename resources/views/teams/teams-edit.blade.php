@extends('layouts.app')
@section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
        <form action="{{ route('teams.update', $team) }}" method="POST" id="team-form">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="mb-3">
                    <label for="team-name" class="form-label">Nome da Equipe</label>
                    <input
                        type="text"
                        name="team_name"
                        id="team-name"
                        class="form-control"
                        value="{{ old('team_name', $team->team_name) }}"
                        placeholder="Digite o nome da sua Equipe"
                        required />
                </div>
            </div>

            <!-- Slots do time -->
            <div class="container d-flex justify-content-center mt-4 mb-4">
                <div class="row row-cols-1 row-cols-md-3 g-4 text-center w-100" id="team-slots">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="col">
                            <div class="card shadow p-3 team-slot" data-slot="{{ $i }}">
                                @php
                                    // Prioriza old() (se houve erro de validação)
                                    $pokemonId = old('team_pokemons')[$i] ?? $team->pokemons[$i]->id ?? null;
                                    $p = $pokemonId ? $pokemons->firstWhere('id', $pokemonId) : null;
                                @endphp

                                @if($p)
                                    <img src="{{ $p->imagem }}"><br>
                                    <strong>{{ $p->nome }}</strong>
                                    <input type="hidden" name="team_pokemons[]" value="{{ $p->id }}">
                                @else
                                    <span class="placeholder">Slot {{ $i+1 }}</span>
                                    <input type="hidden" name="team_pokemons[]" value="">
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <button type="submit" class="btn btn-success">Salvar Alterações</button>
        </form>
    </div>
</div>

<!-- Lista de pokémons (filtros + tabela parcial) -->
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
        <form method="GET" action="{{ route('teams.create') }}" class="mb-3 d-flex" id="filter-form">
            <input type="text" name="name" class="form-control me-2" placeholder="Pesquisar Pokémon" value="{{ $search ?? '' }}">

            <select name="type1" class="form-select me-2">
                <option value="">-- Tipo 1 --</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo }}" {{ ($type1 ?? '') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>

            <select name="type2" class="form-select me-2">
                <option value="">-- Tipo 2 --</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo }}" {{ ($type2 ?? '') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('teams.edit', $team) }}" class="btn btn-warning ms-2">Limpar</a>
        </form>

        <!-- Aqui será trocada pelo AJAX -->
        <div id="pokemon-table">
            @include('teams.partials.pokemon-table', ['pokemons' => $pokemons])
        </div>
    </div>
</div>
@endsection
