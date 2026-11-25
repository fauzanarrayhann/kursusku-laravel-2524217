@extends('layouts.app')

@section('title', 'Login - KursusKu')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h1 class="h3 fw-bold mb-1">Selamat datang 👋</h1>
                <p class="text-muted">Masuk dengan username atau email untuk melanjutkan.</p>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="login" class="form-label fw-semibold">Username / Email</label>
                        <input type="text" id="login" name="login" value="{{ old('login') }}"
                               class="form-control @error('login') is-invalid @enderror"
                               placeholder="Masukkan username atau email"
                               autocomplete="username" autofocus>
                        @error('login')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password"
                                   autocomplete="current-password">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">Lihat</button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="small">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Masuk</button>
                </form>

                <div class="text-center mt-3">
                    <span class="text-muted small">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="small fw-semibold">Daftar sekarang</a>
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
        var btn = document.getElementById('togglePassword');
        btn.addEventListener('click', function () {
            var hidden = input.type === 'password';
            input.type = hidden ? 'text' : 'password';
            btn.textContent = hidden ? 'Sembunyi' : 'Lihat';
        });
    })();
</script>
@endsection
