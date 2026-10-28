<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('learning.profile', ['student' => $request->user()]);
    }

    public function update(Request $request)
    {
        $request->merge(collect($request->only('name', 'student_id', 'gender', 'major'))
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)->all());
        $newPhoto = null;
        $oldPhoto = null;
        try {
            DB::transaction(function () use ($request, &$newPhoto, &$oldPhoto) {
                // Use the same identifier lock as registration to prevent ambiguous logins.
                DB::table('users')->orderBy('id')->lockForUpdate()->first();
                $student = User::whereKey($request->user()->id)->lockForUpdate()->firstOrFail();
                $data = $request->validate([
                    'name' => 'required|string|max:191',
                    'student_id' => ['bail', 'required', 'string', 'min:3', 'max:100', 'regex:/\A[A-Za-z0-9][A-Za-z0-9_.-]*\z/', function ($attribute, $value, $fail) use ($student) {
                        if (User::where('id', '!=', $student->id)->where(function ($query) use ($value) {
                            $query->whereRaw('LOWER(username) = ?', [mb_strtolower($value)])
                                ->orWhereRaw('LOWER(student_id) = ?', [mb_strtolower($value)]);
                        })->exists()) {
                            $fail('This Student ID or username is already in use.');
                        }
                    }],
                    'gender' => 'nullable|string|max:50',
                    'major' => 'nullable|string|max:191',
                    'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120|dimensions:max_width=6000,max_height=6000',
                ]);
                unset($data['photo']);
                if ($request->hasFile('photo')) {
                    $newPhoto = $request->file('photo')->store('avatars', 'public');
                    abort_unless($newPhoto, 500, 'The photo could not be saved. Please try again.');
                    $oldPhoto = $student->avatar;
                    $data['avatar'] = Storage::disk('public')->url($newPhoto);
                }
                $student->update($data);
            });
        } catch (\Throwable $exception) {
            if ($newPhoto) {
                Storage::disk('public')->delete($newPhoto);
            }
            throw $exception;
        }
        $prefix = Storage::disk('public')->url('avatars/');
        if ($oldPhoto && str_starts_with($oldPhoto, $prefix)) {
            $filename = substr($oldPhoto, strlen($prefix));
            if (preg_match('/\A[A-Za-z0-9]+\.(jpg|jpeg|png|webp)\z/', $filename)) {
                Storage::disk('public')->delete('avatars/'.$filename);
            }
        }

        return redirect()->route('learning.profile.edit')->with('success', 'Your profile has been updated.');
    }
}
