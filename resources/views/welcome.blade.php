
@extends('layouts.admin')

@section('content')

    <a href="{{ route('pokedex.index')}}"></a>
    <a href="{{ route('pokedex.index', ['name' => 'pikachu']) }}" class="btn btn-primary">Ver Pokémon</a>
@endsection
