@extends('layouts.app')
@section('content')
    <h1>{{$trainer->trainer_name}}</h1>
    <form method="GET" action="{{ route('listar') }}" class="mb-3 d-flex">
        <input type="text" name="name" class="form-control me-2" placeholder="Pesquisar Equipes" value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary me-3">Buscar</button>
        <a href="{{ route('teams.create') }}"><span class="btn btn-primary">Criar equipe</span></a>
    </form>

@if ($teams->isEmpty())
    <p>Você ainda não tem nenhum time criado.</p>
@else
    @foreach ($teams as $team)
        <div>{{ $team->team_name }}</div>
    @endforeach
@endif


@endsection
