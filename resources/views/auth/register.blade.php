@extends('layouts.app')

@section('title', 'Daftar Akun - KursusKu')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h1 class="h3 fw-bold mb-1">Buat akun baru ✨</h1>
                <p class="text-muted">Isi data berikut untuk mendaftar. Anda bisa melengkapi profil setelah masuk.</p>

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Masukkan nama lengkap" autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}"
                                   class="form-control @error('username') is-invalid @enderror"
                                   placeholder="contoh: budi_01" autocomplete="username">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="nama@email.com" autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Buat password" autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">Lihat</button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimal 8 karakter, mengandung huruf besar-kecil, angka, dan simbol.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Ulangi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" placeholder="Ketik ulang password" autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Daftar</button>
                </form>

                <div class="text-center mt-3">
                    <span class="text-muted small">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" class="small fw-semibold">Masuk di sini</a>
                </div>
                <div class="text-center mt-1">
                    <a href="{{ route('home') }}" class="small">&larr; Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var input = document.getElementById('password');
        var confirmInput = document.getElementById('password_confirmation');
        var btn = document.getElementById('togglePassword');
        btn.addEventListener('click', function () {
            var hidden = input.type === 'password';
            input.type = hidden ? 'text' : 'password';
            confirmInput.type = input.type;
            btn.textContent = hidden ? 'Sembunyi' : 'Lihat';
        });
    })();
</script>
@endsection
