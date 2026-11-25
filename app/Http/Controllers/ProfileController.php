<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'email'       => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'       => ['nullable', 'string', 'max:20'],
            'position'    => ['nullable', 'string', 'max:100'],
            'institution' => ['nullable', 'string', 'max:100'],
            'address'     => ['nullable', 'string', 'max:500'],
        ]);

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', 'different:current_password',
                                   Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $request->user()->update(['password' => $request->password]);

        return back()->with('success', 'Password berhasil diganti.');
    }
}
