@extends('layouts.app')
@section('content')
<div class="text-center">
    <h1>{{$pokemon->nome}} # {{$pokemon->id}}</h1>
</div>
<div class="container mt-4">
    <div class="row align-items-stretch">
        <!-- Coluna da Imagem -->
        <div class="col-md-6 text-center">
            <div class="card shadow p-3 h-100">
                <figure class="figure">
                    <img
                        id="pokemon-img"
                        src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{{ $pokemon->id }}.png"
                        alt="{{ $pokemon->nome }}"
                        class="img-fluid"
                        style="max-width: 65%"
                    />
                </figure>
            </div>
        </div>

        <!-- Coluna das Características -->
        <div class="col-md-6 d-flex">
            <div class="card shadow p-3 h-100 w-100">
                <div class="card-body">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <!-- Coluna esquerda -->
                        <div class="col-md-6 d-flex row justify-content-center text-center">
                            <div>
                                <h3>Altura</h3>
                                <h6>{{$pokemon->altura /10}} M</h6>
                            </div>
                            <div>
                                <h3>Peso</h3>
                                <h6>{{$pokemon->peso /10}} Kg</h6>
                            </div>
                        </div>

                        <!-- Coluna direita -->
                        <div class="col-md-6 d-flex row justify-content-center text-center">
                            <div>
                                <h3>Tipo</h3>
                                <h6>{{$pokemon->tipo}}</h6>
                            </div>
                            <div>
                                <h3>Habilidades</h3>
                                <h6>{{$pokemon->habilidades}}</h6>
                            </div>
                        </div>


                            <button id="shiny-toggle" data-id="{{ $pokemon->id }}" class="btn btn-warning">Shiny</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="col-md-12 mt-4">
            <div class="card shadow p-3">
                <div class="card-body">
                    <h1 class="text-center">Status</h1>
                    <div class="d-flex">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Hp', 'Attack', 'Defesa', 'Special attack', 'Special defense', 'Speed'],
      datasets: [{
        label: 'Status',
        data: [{{$pokemon->hp}}, {{$pokemon->attack}}, {{$pokemon->defense}}, {{$pokemon->special_attack}}, {{$pokemon->special_defense}}, {{$pokemon->speed}}],
        borderWidth: 1,
        backgroundColor: [
          'rgb(54, 162, 235)',
          'rgb(255, 99, 132)',
        ],
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
@endsection
