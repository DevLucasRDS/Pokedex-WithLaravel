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
                            @if($key !== 'tipo') {{-- tipo não é numérico nem status --}}
                            <a href="{{ route('listar', [
                                'sort' => $key,
                                'order' => ($sort === $key && $order === 'asc') ? 'desc' : 'asc',
                                'name' => $search ?? null
                            ]) }}" class="text-light text-decoration-none">
                                {{ $label }}
                                @if($sort === $key)
                                    {{ $order === 'asc' ? '▲' : '▼' }}
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
                    <td class="d-flex align-items-center justify-content-center">
                        <img src="{{ $pokemon['imagem'] }}" class="me-2">
                        <span>{{ $pokemon->id }}</span>
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
