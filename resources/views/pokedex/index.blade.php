@extends('layouts.app') {{-- antes estava registrado ou visitante --}}

@section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-header me-2">
        <span>Pesquisar</span>
        <form action="{{ route('pokedex.index') }}" method="GET" class="d-flex">
            <input
                type="text"
                name="name"
                class="form-control me-2"
                placeholder="Digite o nome do Pokémon"
                value="{{ request('name') }}"
            >
            <div class="pd-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{route('pokedex.index')}}" class="btn btn-warning btn-sm"> Limpar</a>
            </div>
        </form>
    </div>

    <div class="container d-flex justify-content-center mt-4 mb-4">
        <div class="row row-cols-1 row-cols-md-3 g-4 text-center w-100">
            @if ($error)
                <p class="text-danger">{{ $error }}</p>
            @else
                @foreach ($pokemons as $pokemon)
                    <div class="col">
                        <div class="card shadow p-3">
                            <img
                                src="{{ $pokemon['imagem'] }}"
                                class="card-img-top w-50 mx-auto d-block"
                                alt="{{ $pokemon['nome'] }}"
                            />
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $pokemon['nome'] }}</h5>
                                <p class="card-text">
                                    <strong>Tipo:</strong> {{ $pokemon['tipo'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Paginação só aparece quando não há pesquisa --}}
    @if (!request('name'))
    <div class="d-flex justify-content-center mt-4 mb-3">
        <a
            href="{{ route('pokedex.index', ['page' => $page > 1 ? $page - 1 : 1]) }}"
            class="btn btn-secondary me-2"
        >
            Anterior
        </a>
        <a
            href="{{ route('pokedex.index', ['page' => $page + 1]) }}"
            class="btn btn-primary"
        >
            Próximo
        </a>
    </div>
    @endif
</div>
@endsection
