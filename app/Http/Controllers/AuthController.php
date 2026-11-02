<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AccountIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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

            if (Auth::user()->must_change_password) {
                return redirect()->route('password.create');
            }

            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.index' : 'campus.index');
        }

        return back()->withErrors(['login' => 'The ID/username or password is incorrect, or the account is inactive.'])->onlyInput('login');
    }

    public function createPassword(Request $request)
    {
        abort_unless($request->user()->status === 'Active', 403);
        if (! $request->user()->must_change_password) {
            return redirect()->route($request->user()->role === 'admin' ? 'admin.index' : 'campus.index');
        }

        return response()->view('auth.create-password')->header('Cache-Control', 'no-store, private');
    }

    public function storePassword(Request $request)
    {
        $user = $request->user();
        abort_unless($user->status === 'Active' && $user->must_change_password, 403);
        $data = $request->validate(['password' => 'required|string|min:8|max:255|confirmed']);
        if (Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['password' => 'Choose a new password different from your temporary password.']);
        }
        $user->password = $data['password'];
        $user->must_change_password = false;
        $user->remember_token = Str::random(60);
        $user->save();
        $request->session()->regenerate();

        return redirect()->route($user->role === 'admin' ? 'admin.index' : 'campus.index')->with('success', 'Your new password has been saved.');
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
