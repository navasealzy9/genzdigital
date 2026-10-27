<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        if (Auth::attempt($credentials + ['status' => 'Active'], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.index' : 'campus.index');
        }

        return back()->withErrors(['email' => 'The credentials are incorrect or the account is inactive.'])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191', 'email' => 'required|email|max:191|unique:users',
            'password' => 'required|string|min:8|confirmed', 'role' => 'sometimes|in:student',
        ]);
        $user = User::create([
            'name' => $data['name'], 'email' => $data['email'], 'password' => $data['password'],
            'role' => 'student', 'status' => 'Active', 'student_id' => 'GZ-'.Str::upper(Str::random(12)),
        ]);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('campus.index')->with('success', 'Welcome! Choose a course to start learning.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
