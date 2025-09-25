<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonControler;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {

    // Página inicial — redireciona para a pokédex
    Route::get('/', [PokemonControler::class, 'pokedex'])->name('pokedex.index');

    // Registro de usuário
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    // Login/Logout
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Pokedex pública (qualquer pessoa pode acessar)
    Route::get('/pokedex', [PokemonControler::class, 'pokedex'])->name('pokedex.index');

    // Listagem de Pokémons
    Route::get('/listar-pokemon', [PokemonControler::class, 'listar'])->name('listar');

    // Página de especificação do Pokémon
    Route::get('/especificacao-pokemon/{pokemon}', [PokemonControler::class, 'especificacao'])->name('especificacao');

    // Dashboard privado (apenas usuários logados)
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [PokemonControler::class, 'pokedexDashboard'])->name('dashboard');
    });
});
