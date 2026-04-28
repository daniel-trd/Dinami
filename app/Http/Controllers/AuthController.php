<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && $user->status !== 'ativo') {
            return back()->with('error', 'Usuário inativo.');
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'status' => 'ativo'
        ])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email ou senha inválidos');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
