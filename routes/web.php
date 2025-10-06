<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonControler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Http\Controllers\TeamController;

Route::get('/', function () {
    return view('create-account');
});
//Rotas de registrar
Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

//Rotas de login e logout
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Pokedex pública (qualquer pessoa pode acessar)
Route::get('/pokedex', [PokemonControler::class, 'pokedex'])->name('pokedex.index');

// Dashboard privado (apenas logados)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PokemonControler::class, 'pokedexDashboard'])->name('dashboard');
});

// Rota de Listar o pokemon
Route::get('/listar-pokemon', [PokemonControler::class, 'listar'])->name('listar');

//Rota de especificação de pokemon
Route::get('/especificacao', [PokemonControler::class, 'especificacao'])->name('especificacao');


// Listar times do treinador autenticado
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');

// Formulário de criação de time
Route::get('/teams-create', [TeamController::class, 'create'])->name('teams.create');

// Salvar time novo
Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');

// Visualizar um time específico
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

// Formulário de edição do time
Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');

// Atualizar o time
Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');

// Deletar um time
Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
