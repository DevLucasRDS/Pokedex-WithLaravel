<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('create-account');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'trainer_name' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['nome'],
            'sobrenome' => $validated['sobrenome'],
            'email' => $validated['email'],
            'password'  => Hash::make($validated['password']),
        ]);

        // Cria o treinador vinculado ao usuário
        $user->trainer()->create([
            'trainer_name' => $validated['trainer_name'],
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Conta criada com sucesso!');
    }
}
