<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonControler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;

Route::get('/', function () {
    return view('create-account');
});
Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Pokedex pública (qualquer pessoa pode acessar)
Route::get('/pokedex', [PokemonControler::class, 'pokedex'])->name('pokedex.index');

// Dashboard privado (apenas logados)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PokemonControler::class, 'pokedexDashboard'])->name('dashboard');
});
Route::get('/especificacao-pokemon/{pokemon}', [PokemonControler::class, 'especificacao'])->name('especificacao');
//Listagem pokemon//
Route::get('/listar-pokemon', [PokemonControler::class, 'listar'])->name('listar');
