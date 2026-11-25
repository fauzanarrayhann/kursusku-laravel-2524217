<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Bisa login memakai username ATAU email
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field      => $request->login,
            'password'  => $request->password,
            'is_active' => true,
        ];

        // Argumen kedua = fitur "Ingat saya" (remember me)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->user()->update(['last_login_at' => now()]);

            return redirect()->intended(route('profile.index'));
        }

        return back()
            ->withErrors(['login' => 'Username/email atau password salah, atau akun tidak aktif.'])
            ->onlyInput('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Samakan huruf kecil agar username/email tidak ganda karena beda kapital
        $request->merge([
            'username' => Str::lower(trim((string) $request->username)),
            'email'    => Str::lower(trim((string) $request->email)),
        ]);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash:ascii', 'unique:users,username'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ], [
            'username.unique'     => 'Username sudah dipakai, silakan pilih yang lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip (-), dan garis bawah (_).',
            'username.min'        => 'Username minimal 3 karakter.',
            'email.unique'        => 'Email sudah terdaftar. Silakan login atau gunakan email lain.',
            'password.confirmed'  => 'Konfirmasi password tidak sama.',
        ]);

        // Role dan status SELALU ditentukan server, tidak diambil dari form
        $user = User::create([
            'name'          => $data['name'],
            'username'      => $data['username'],
            'email'         => $data['email'],
            'password'      => $data['password'], // di-hash otomatis oleh cast "hashed"
            'role'          => 'user',
            'is_active'     => true,
            'last_login_at' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('profile.index')
            ->with('success', 'Akun berhasil dibuat. Selamat datang di KursusKu!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda berhasil logout.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Reset password langsung (tanpa kirim email).
     * Username dan email harus cocok dengan satu akun yang sama.
     */
    public function resetPasswordDirect(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $user = User::where('username', $data['username'])
            ->where('email', $data['email'])
            ->first();

        if (! $user) {
            return back()
                ->withErrors(['email' => 'Username dan email tidak cocok dengan akun mana pun.'])
                ->onlyInput('username', 'email');
        }

        // 'password' otomatis di-hash oleh cast "hashed" pada model User
        $user->forceFill([
            'password'       => $data['password'],
            'remember_token' => Str::random(60),
        ])->save();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
