<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AccountIdentity;
use Illuminate\Http\Request;

class AccountManageController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => 'nullable|string|max:100',
            'role' => 'nullable|in:student,admin',
        ]);
        $search = trim($filters['q'] ?? '');
        $accounts = User::whereIn('role', ['student', 'admin'])
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('username', 'like', '%'.$search.'%')
                ->orWhere('student_id', 'like', '%'.$search.'%')))
            ->when($filters['role'] ?? null, fn ($query, $role) => $query->where('role', $role))
            ->orderByDesc('id')->paginate(12)->withQueryString();

        return response()->view('admin.accounts', compact('accounts', 'search'))
            ->header('Cache-Control', 'no-store, private');
    }

    public function store(Request $request, AccountIdentity $identity)
    {
        $data = $request->validate(['role' => 'required|in:student,admin']);
        $identity->create($request->except('role'), $data['role']);

        return redirect()->route('admin.accounts.index')
            ->with('success', ucfirst($data['role']).' account created successfully.');
    }
}
