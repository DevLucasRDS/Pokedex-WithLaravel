@extends('layouts.app')

@section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-body">
        <h3>{{ $team->team_name }}</h3>
        <p><strong>Criado em:</strong> {{ $team->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Treinador:</strong> {{ $team->trainer->trainer_name}}</p>

        <h4>Pokémons da Equipe:</h4>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($team->pokemons as $pokemon)
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
    </div>
</div>
@endsection
