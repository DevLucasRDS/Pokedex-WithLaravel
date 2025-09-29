@extends('layouts.app') @section('content')
<div class="text-center">
    <h1>{{$pokemon->nome}} # {{$pokemon->id}}</h1>
</div>
<div class="container mt-4">
    <div class="row">
        <!-- Coluna da Imagem -->
        <div class="col-md-6 text-center">
            <div class="card shadow p-3">
                <figure class="figure">
                    <img
                        src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{{ $pokemon->id }}.png"
                        alt="{{ $pokemon->nome }}"
                        class="img-fluid"
                        style="max-width: 65%"
                    />
                </figure>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow p-3">
                <div class="card-body">
                    <div class="row">
                        <!-- Coluna esquerda -->
                        <div class="col-md-6 d-flex row justify-content-center text-center" >
                            <div

                            >
                                <h3>altura</h3>
                                <h6>{{$pokemon->altura /10}} M</h6>
                            </div>
                            <div

                            >
                                <h3>Peso</h3>
                                <h6>{{$pokemon->peso /10}} Kg</h6>
                            </div>
                        </div>


                        <!-- Coluna direita -->
                        <div class="col-md-6 text-end d-flex row justify-content-center text-center">
                            <div>
                                <h3>Tipo</h3>
                                <h6>{{$pokemon->tipo}}</h6>
                            </div>
                            <div>
                                <h3>Habilidades</h3>
                                <h6>{{$pokemon->habilidades}}</h6>
                            </div>
                        </div>
                        <div class="d-flex row justify-content-center text-center">
                            @auth
                                <a href="#" class="btn btn-success btn-sm">Favoritar</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
