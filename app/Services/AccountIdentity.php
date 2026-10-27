<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountIdentity
{
    public function create(array $input, string $role = 'student'): User
    {
        foreach (['username', 'student_id'] as $field) {
            if (isset($input[$field]) && is_string($input[$field])) {
                $input[$field] = trim($input[$field]);
            }
        }
        if (empty($input['username']) && isset($input['student_id']) && is_string($input['student_id'])) {
            $input['username'] = $input['student_id'];
        }
        if (isset($input['username']) && is_string($input['username'])) {
            $input['username'] = Str::lower($input['username']);
        }

        return DB::transaction(function () use ($input, $role) {
            // Serialize registrations so usernames cannot claim another student's ID namespace.
            DB::table('users')->orderBy('id')->lockForUpdate()->first();
            $available = function ($attribute, $value, $fail) {
                if (User::whereRaw('LOWER(username) = ?', [Str::lower($value)])->orWhereRaw('LOWER(student_id) = ?', [Str::lower($value)])->exists()) {
                    $fail('This username or student ID is already in use.');
                }
            };
            $data = Validator::make($input, [
                'name' => 'required|string|max:191',
                'username' => ['bail', 'required', 'string', 'min:3', 'max:100', 'regex:/\A[a-z0-9][a-z0-9_.-]*\z/', $available],
                'student_id' => ['bail', 'nullable', 'string', 'min:3', 'max:100', 'regex:/\A[A-Za-z0-9][A-Za-z0-9_.-]*\z/', $available],
                'password' => 'required|string|min:8|confirmed', 'role' => 'sometimes|in:student',
                'major' => 'nullable|string|max:191', 'gender' => 'nullable|string|max:50',
            ])->validate();
            if (empty($data['student_id']) && $role === 'student') {
                do {
                    $data['student_id'] = 'GZ-'.Str::upper(Str::random(12));
                } while (User::whereRaw('LOWER(username) = ?', [Str::lower($data['student_id'])])->orWhereRaw('LOWER(student_id) = ?', [Str::lower($data['student_id'])])->exists());
            }
            unset($data['role']);

            return User::create($data + ['role' => $role, 'status' => 'Active']);
        });
    }
}
