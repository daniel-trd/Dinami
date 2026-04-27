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
        $credenciais = $request->only('email', 'password');

        if (Auth::attempt($credenciais)) {
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
