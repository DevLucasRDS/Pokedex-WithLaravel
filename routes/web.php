<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonControler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth');

Route::get('/dashboard', function(){
    return 'tela do dashboard';
})->name('dashboard');


Route::get('/index-pokedex', [PokemonControler::class, 'pokemon'])->name('pokedex.index');