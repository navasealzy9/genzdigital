<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AccountIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $credentials = $request->validate(['login' => 'required|string|max:100', 'password' => 'required|string']);
        $identifier = mb_strtolower(trim($credentials['login']));
        $accounts = User::where(fn ($q) => $q->whereRaw('LOWER(username) = ?', [$identifier])->orWhereRaw('LOWER(student_id) = ?', [$identifier]))->limit(2)->get();
        if ($accounts->count() === 1 && Auth::attempt(['id' => $accounts->first()->id, 'password' => $credentials['password'], 'status' => 'Active'], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.index' : 'campus.index');
        }

        return back()->withErrors(['login' => 'The ID/username or password is incorrect, or the account is inactive.'])->onlyInput('login');
    }

    public function register(Request $request, AccountIdentity $identity)
    {
        $user = $identity->create($request->all());
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
