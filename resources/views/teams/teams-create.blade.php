@extends('layouts.app') @section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
        <form action="teams.store" method="post">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label for="team-name" class="form_label">Nome da Equipe</label>
                    <input
                        type="text"
                        name="team-name"
                        id="team-name"
                        class="form-control"
                        value="{{ old('team-name') }}"
                        placeholder="Digite o nome da sua Equipe"
                        required />
                </div>

            </div>
        </form>
    </div>
</div>
<div class="card mt-4 mb-4 border shadow">
    <div class="container d-flex justify-content-center mt-4 mb-4">
        <div class="row row-cols-1 row-cols-md-3 g-4 text-center w-100">
            <div class="col">
                <div class="card shadow p-3">
                    <span>COLLUM</span>
                </div>
            </div>
            <div class="col">
                <div class="card shadow p-3">
                    <span>COLLUM</span>
                </div>
            </div>
            <div class="col">
                <div class="card shadow p-3">
                    <span>COLLUM</span>
                </div>
            </div>
            <div class="col">
                <div class="card shadow p-3">
                    <span>COLLUM</span>
                </div>
            </div>
            <div class="col">
                <div class="card shadow p-3">
                    <span>COLLUM</span>
                </div>
            </div>
            <div class="col">
                <div class="card shadow p-3">
                    <span>COLLUM</span>
                </div>
            </div>

        </div>
    </div>
    <div class="card-body">
        <!-- Formulário de pesquisa -->
        <form method="GET" action="{{ route('teams.create') }}" class="mb-3 d-flex">
            <input
                type="text"
                name="name"
                class="form-control me-2"
                placeholder="Pesquisar Pokémon"
                value="{{ $search ?? '' }}" />
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    @php
                    $columns = [
                    'id' => 'ID',
                    'nome' => 'Nome',
                    'tipo' => 'Tipo',
                    'hp' => 'HP',
                    'attack' => 'Attack',
                    'defense' => 'Defense',
                    'special-attack' => 'Sp.Atk',
                    'special-defense' => 'Sp.Def',
                    'speed' => 'Speed'
                    ];
                    @endphp

                    @foreach ($columns as $key => $label)
                    <th>
                        @if($key !== 'tipo')
                        <a href="{{ route('teams.create', [
                'sort' => $key,
                'order' => ($sort === $key && $order === 'asc') ? 'desc' : 'asc',
                'name' => $search ?? null
            ]) }}" class="text-light text-decoration-none">
                            {{ $label }}
                            @if($sort === $key)
                            {{ $order === "asc" ? "▲" : "▼" }}
                            @endif
                        </a>
                        @else
                        {{ $label }}
                        @endif
                    </th>
                    @endforeach

                </tr>
            </thead>
            <tbody>
                @foreach($pokemons as $pokemon)
                <tr>
                    <td
                        class="d-flex align-items-center justify-content-center">
                        <img src="{{ $pokemon['imagem'] }}" class="me-2" />
                        <span>{{ $pokemon["id"] }}</span>
                    </td>
                    <td class="text-decoration-none">{{ $pokemon->nome }}</td>
                    <td>{{ $pokemon->tipo }}</td>
                    <td>{{ $pokemon->hp }}</td>
                    <td>{{ $pokemon->attack }}</td>
                    <td>{{ $pokemon->defense }}</td>
                    <td>{{ $pokemon->special_attack }}</td>
                    <td>{{ $pokemon->special_defense }}</td>
                    <td>{{ $pokemon->speed }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection