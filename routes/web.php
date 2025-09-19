<?php

use App\Http\Controllers\PokemonControler;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/index-pokedex', [PokemonControler::class, 'index'])->name('pokedex.index');
