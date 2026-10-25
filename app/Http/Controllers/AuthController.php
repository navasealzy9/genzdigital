<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the Login page.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.index')
                : redirect()->route('campus.index');
        }
        return view('auth.login');
    }

    /**
     * Handle Login submission.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.index'))->with('success', 'Welcome back, ' . $user->name . ' (Admin)!');
            }

            return redirect()->intended(route('campus.index'))->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our campus records.',
        ])->onlyInput('email');
    }

    /**
     * Show the Register page.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.index')
                : redirect()->route('campus.index');
        }
        return view('auth.register');
    }

    /**
     * Handle User Registration.
     */
    public function register(Request $request)
    {
        // Prohibit Admin registration
        if (strtolower((string) $request->input('role')) === 'admin') {
            return back()->withErrors([
                'role' => 'ការចុះឈ្មោះគណនី Admin មិនត្រូវបានអនុញ្ញាតទេ! គណនី Admin អាចផ្តល់ជូនបានតែដោយរដ្ឋបាលសាកលវិទ្យាល័យប៉ុណ្ណោះ។ (Admin registration is strictly prohibited).',
            ])->withInput();
        }

        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|string',
            'student_id' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:191',
            'gender' => 'nullable|string|max:50',
        ]);

        $role = 'student'; // Strictly enforce student role for self-registration
        $studentId = $request->student_id ?: ('GZ' . date('Y') . rand(1000, 9999));
        $major = $request->major ?: 'Visual Communication';
        $gender = $request->gender ?: 'Female';
        $avatar = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'student_id' => $role === 'student' ? $studentId : null,
            'major' => $role === 'student' ? $major : 'Faculty Administration',
            'gender' => $gender,
            'avatar' => $avatar,
            'status' => 'Active',
        ]);

        // If registered as student, sync to campus_students table
        if ($role === 'student') {
            DB::table('campus_students')->updateOrInsert(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'student_id' => $studentId,
                    'email' => $user->email,
                    'major' => $major,
                    'gender' => $gender,
                    'avatar' => $avatar,
                    'status' => 'Active',
                    'attendance_rate' => '100%',
                    'valid_until' => '08/2028',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.index')->with('success', 'Admin account registered successfully!');
        }

        return redirect()->route('campus.index')->with('success', 'Registration successful! Welcome to GenZ Digital Campus OS.');
    }

    /**
     * Handle Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out safely.');
    }
}
