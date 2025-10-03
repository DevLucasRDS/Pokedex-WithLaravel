@extends('layouts.app')
@section('content')
    <h1>{{ $trainer->trainer_name }}</h1>

    <form method="GET" action="{{ route('teams.index') }}" class="mb-3 d-flex">
        <input type="text" name="name" class="form-control me-2" placeholder="Pesquisar Equipes" value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary me-3">Buscar</button>
        <a href="{{ route('teams.create') }}"><span class="btn btn-primary">Criar equipe</span></a>
    </form>

    @if ($teams->isEmpty())
        <p>Você ainda não tem nenhum time criado.</p>
    @else

        @foreach ($teams as $team)
            <div class="card mb-3 shadow">
                <div class="card-header">
                    <h4 class="mb-0">
                        <a class="text-decoration-none"
                           data-bs-toggle="collapse"
                           href="#team-{{ $team->id }}"
                           role="button"
                           aria-expanded="false"
                           aria-controls="team-{{ $team->id }}">
                            {{ $team->team_name }}
                        </a>
                    </h4>
                </div>

                <div class="collapse" id="team-{{ $team->id }}">
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @forelse($team->pokemons->sortBy('pivot.slot') as $pokemon)
                                <div class="col">
                                    <div class="card shadow text-center">
                                        <img src="{{ $pokemon->imagem }}" class="card-img-top mx-auto p-2" style="max-width:120px">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $pokemon->nome }}</h5>
                                            <p class="card-text">
                                                Tipo: {{ $pokemon->tipo }} <br>
                                                HP: {{ $pokemon->hp }} <br>
                                                Ataque: {{ $pokemon->attack }} <br>
                                                Defesa: {{ $pokemon->defense }}
                                            </p>
                                            <small>Slot: {{ $pokemon->pivot->slot + 1 }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Nenhum Pokémon adicionado ainda.</p>
                            @endforelse

                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <a href="{{ route('teams.edit', ['team' => $team -> id]) }}">
                            <button type="button" class="btn btn-warning btn-sm me-1 fs-5"">Editar</button>
                        </a>
                         <form id="formExcluir{{$team ->id}}" action="{{ route('teams.destroy', $team->id) }}" method="POST" class="delete-form d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger  btn-sm me-1 btnDelete fs-5" data-delete-id="{{ $team->id}}">Apagar</button>
                        </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
