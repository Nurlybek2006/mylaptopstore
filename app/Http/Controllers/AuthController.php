<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Кіру беті
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Кіру процесі
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Пайдаланушы аты немесе email арқылы кіру
        $field = filter_var($credentials['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Рөліне қарай бағыттау
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Қош келдіңіз, админ!');
            } else {
                return redirect()->route('home')->with('success', 'Қош келдіңіз, ' . $user->username . '!');
            }
        }

        return back()->withErrors([
            'username' => 'Қате пайдаланушы аты немесе құпия сөз',
        ])->onlyInput('username');
    }

    // Тіркелу беті
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Тіркелу процесі
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Пайдаланушыны жасау
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        // Автоматты түрде кіру
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Тіркелу сәтті аяқталды! Қош келдіңіз, ' . $user->username . '!');
    }

    // Шығу
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}