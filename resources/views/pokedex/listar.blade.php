@extends('layouts.app')

@section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">

        <!-- Formulário de pesquisa -->
        <form method="GET" action="{{ route('listar') }}" class="mb-3 d-flex">
    <input type="text" name="name" class="form-control me-2" placeholder="Pesquisar Pokémon" value="{{ $search ?? '' }}">

    <!-- Select Tipo 1 -->
    <select name="type1" class="form-select me-2">
        <option value="">-- Tipo 1 --</option>
        @foreach($tipos as $tipo)
            <option value="{{ $tipo }}" {{ ($type1 ?? '') === $tipo ? 'selected' : '' }}>
                {{ $tipo }}
            </option>
        @endforeach
    </select>

    <!-- Select Tipo 2 -->
    <select name="type2" class="form-select me-2">
        <option value="">-- Tipo 2 --</option>
        @foreach($tipos as $tipo)
            <option value="{{ $tipo }}" {{ ($type2 ?? '') === $tipo ? 'selected' : '' }}>
                {{ $tipo }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-primary">Buscar</button>
    <a href="{{ route('listar') }}" class="btn btn-warning ms-2">Limpar</a>
 </form>

 @if($pokemons->isEmpty())
    <div class="alert alert-warning text-center">
        Nenhum Pokémon encontrado para os filtros informados.
    </div>
@else
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
@endif

    </div>
</div>
@endsection
