<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Показ формы входа/регистрации
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    // Обработка регистрации
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']), // Обязательно шифруем пароль!
        ]);

        Auth::login($user); // Сразу авторизуем после регистрации
        return redirect()->route('home')->with('success', 'Добро пожаловать, ' . $user->name . '!');
    }

    // Обработка входа
    public function login(Request $request) {
        $credentials = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors(['phone' => 'Неверный телефон или пароль']);
    }

    // Выход из аккаунта
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Страница профиля
    public function profile() {
        return view('profile');
    }
}