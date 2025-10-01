@extends('layouts.app')
@section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
        <form action="{{ route('teams.store') }}" method="post" id="team-form">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label for="team-name" class="form-label">Nome da Equipe</label>
                    <input
                        type="text"
                        name="team_name"
                        id="team-name"
                        class="form-control"
                        value="{{ old('team_name') }}"
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
                                    $pokemonId = old('team_pokemons')[$i] ?? '';
                                    $p = $pokemons->firstWhere('id', $pokemonId);
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

            <button type="submit" class="btn btn-success">Salvar Time</button>
        </form>
    </div>
</div>

<!-- Lista de pokémons -->
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
        <form method="GET" action="{{ route('teams.create') }}" class="mb-3 d-flex">
            <input type="text" name="name" class="form-control me-2" placeholder="Pesquisar Pokémon" value="{{ $search ?? '' }}">

            <!-- Select Tipo 1 -->
            <select name="type1" class="form-select me-2">
                <option value="">-- Tipo 1 --</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo }}" {{ ($type1 ?? '') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>

            <!-- Select Tipo 2 -->
            <select name="type2" class="form-select me-2">
                <option value="">-- Tipo 2 --</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo }}" {{ ($type2 ?? '') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>

            <!-- Manter Pokémon selecionados nos filtros -->
            @foreach(old('team_pokemons', []) as $pid)
                <input type="hidden" name="team_pokemons[]" value="{{ $pid }}">
            @endforeach

            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('teams.create') }}" class="btn btn-warning ms-2">Limpar</a>
        </form>

        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>HP</th>
                    <th>Atk</th>
                    <th>Def</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pokemons as $pokemon)
                <tr class="pokemon-row"
                    data-id="{{ $pokemon->id }}"
                    data-nome="{{ $pokemon->nome }}"
                    data-img="{{ $pokemon->imagem }}">
                    <td><img src="{{ $pokemon->imagem }}"> {{ $pokemon->id }}</td>
                    <td>{{ $pokemon->nome }}</td>
                    <td>{{ $pokemon->tipo }}</td>
                    <td>{{ $pokemon->hp }}</td>
                    <td>{{ $pokemon->attack }}</td>
                    <td>{{ $pokemon->defense }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
