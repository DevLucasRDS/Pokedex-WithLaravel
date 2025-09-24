@extends('layouts.app')

@section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">

        <!-- Formulário de pesquisa -->
        <form method="GET" action="{{ route('listar') }}" class="mb-3 d-flex gap-2">
            <input
                type="text"
                name="name"
                class="form-control me-2"
                placeholder="Pesquisar Pokémon"
                value="{{ $search }}"
            >
            <select name="type" class="form-select me-2">
                <option value="">-- Tipo --</option>
                @foreach (['fire','water','grass','electric','ice','fighting','poison','ground','flying','psychic','bug','rock','ghost','dragon','dark','steel','fairy'] as $t)
                <option value="{{ $t }}" {{ ($type ?? '') === $t ? 'selected' : '' }}>
                {{ ucfirst($t) }}
                </option>
                    @endforeach
        </select>
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{route('listar')}}" class="btn btn-warning btn-sm"> Limpar</a>
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
                            'special_attack' => 'Sp.Atk',
                            'special_defense' => 'Sp.Def',
                            'speed' => 'Speed'
                        ];
                    @endphp

                    @foreach ($columns as $key => $label)
                        <th>
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
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($pokemons as $pokemon)
                <tr>
                    <th class="d-flex align-items-center justify-content-center">
                        <img src="{{ $pokemon->imagem }}" class="me-2">
                        <span>{{ $pokemon->id }}</span>
                    </th>
                    <td>{{ $pokemon->nome }}</td>
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
