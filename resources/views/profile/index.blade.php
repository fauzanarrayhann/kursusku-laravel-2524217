@extends('layouts.app')

@section('title', 'Profil Saya - KursusKu')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Profil Saya</h1>
        <p class="text-muted mb-0">Perbarui identitas, kontak, email login, dan password Anda.</p>
    </div>
    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
</div>

<div class="row g-4">
    {{-- Identitas & Kontak --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Identitas &amp; Kontak</h2>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Login *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="form-text">Setelah disimpan, email baru digunakan pada login berikutnya.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">Nomor HP</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="Contoh: 081234567890">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="position" class="form-label">Jabatan</label>
                            <input type="text" id="position" name="position" value="{{ old('position', $user->position) }}"
                                   class="form-control @error('position') is-invalid @enderror">
                            @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="institution" class="form-label">Instansi / Unit</label>
                            <input type="text" id="institution" name="institution" value="{{ old('institution', $user->institution) }}"
                                   class="form-control @error('institution') is-invalid @enderror">
                            @error('institution') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea id="address" name="address" rows="3"
                                      class="form-control @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Kolom kanan --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Informasi Akses</h2>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Username</span>
                    <span>{{ $user->username ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Role</span>
                    <span class="badge bg-dark text-uppercase">{{ $user->role }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Status</span>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Login terakhir</span>
                    <span>{{ $user->last_login_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="h5 mb-1">Ganti Password</h2>
                <p class="text-muted small mb-3">
                    Password baru minimal 8 karakter serta mengandung huruf besar-kecil, angka, dan simbol.
                </p>

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-2">
                        <input type="password" name="current_password" placeholder="Password saat ini"
                               class="form-control @error('current_password') is-invalid @enderror"
                               autocomplete="current-password">
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-2">
                        <input type="password" name="password" placeholder="Password baru"
                               class="form-control @error('password') is-invalid @enderror"
                               autocomplete="new-password">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                               class="form-control" autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn btn-outline-success w-100">Ganti Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
