<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    public function store(Request $request, User $user)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $User = User::create([
            'name' => $data['nome'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($User);
        return redirect()->route('pokedex.index')->with('success', 'Conta criada com sucesso!');
    }
}
