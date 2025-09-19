
@extends('layouts.admin')

@section('content')

    @if ($error)
        <p class="text-danger">{{ $error }}</p>
    @else
        @foreach ($pokemons as $pokemon)
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ $pokemon['imagem'] }}" class="img-fluid rounded-start" alt="{{ $pokemon['nome'] }}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pokemon['nome'] }}</h5>
                            <p class="card-text">
                                <strong>Altura:</strong> {{ $pokemon['altura'] }}<br>
                                <strong>Peso:</strong> {{ $pokemon['peso'] }}<br>
                                <strong>Habilidades:</strong> {{ implode(', ', $pokemon['habilidades']) }}<br>
                                <strong>Tipo:</strong> {{ $pokemon['tipo'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
