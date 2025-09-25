<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function create()
    {
        return view('create-account');
    }

    public function store(Request $request, User $user)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'trainer_name' => 'required|string|max:255',
        ]);

        $User = User::create([
            'name' => $data['nome'],
            'sobrenome' => $data['sobrenome'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Criar o treinador associado ao usuário
        $User->trainer()->create([
            'trainer_name' => $data['trainer_name'],
        ]);

        Auth::login($User);
        Log::info('Usuário autenticado: ' . (Auth::check() ? 'Sim' : 'Não'));
        return redirect()->route('pokedex.index')->with('success', 'Conta criada com sucesso!');
    }
}
