@extends('layouts.app')

@section('title', 'Lupa Password - KursusKu')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h1 class="h4 fw-bold mb-1">Lupa password?</h1>
                <p class="text-muted">
                    Masukkan username dan email akun Anda, lalu buat password baru.
                </p>

                <form method="POST" action="{{ route('password.update.direct') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                               class="form-control @error('username') is-invalid @enderror" autofocus>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password baru</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">Lihat</button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimal 8 karakter, mengandung huruf besar-kecil, angka, dan simbol.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Ulangi password baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Simpan Password Baru</button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="small">&larr; Kembali ke Login</a>
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
