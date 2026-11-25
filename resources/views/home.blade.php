@extends('layouts.app')

@section('title', 'Beranda Kursusku')

@section('content')
<style>
    /* ===== Beranda Kursusku ===== */
    .kk-hero {
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem;
        padding: 3.5rem 2.5rem;
        color: #fff;
        background: linear-gradient(135deg, #0f172a 0%, #123524 55%, #198754 130%);
    }
    .kk-hero::before {
        content: "";
        position: absolute;
        width: 420px; height: 420px;
        top: -140px; right: -100px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(25, 135, 84, .55), transparent 70%);
        pointer-events: none;
    }
    .kk-hero::after {
        content: "";
        position: absolute;
        width: 320px; height: 320px;
        bottom: -160px; left: -80px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(32, 201, 151, .25), transparent 70%);
        pointer-events: none;
    }
    .kk-hero > .row { position: relative; z-index: 1; }

    .kk-badge {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .35rem .9rem;
        border-radius: 999px;
        font-size: .85rem; font-weight: 600;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .2);
    }
    .kk-badge i {
        width: .5rem; height: .5rem; border-radius: 50%;
        background: #20c997; display: inline-block;
    }
    .kk-title { font-size: clamp(2.1rem, 4.5vw, 3.4rem); line-height: 1.15; }
    .kk-grad {
        background: linear-gradient(90deg, #5eead4, #4ade80);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent; color: transparent;
    }
    .kk-chip {
        display: inline-block;
        padding: .3rem .8rem; margin: 0 .35rem .5rem 0;
        border-radius: 999px; font-size: .85rem;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .15);
    }

    /* Jendela kode dekoratif */
    .kk-code {
        border-radius: 1rem;
        background: #0b1220;
        border: 1px solid rgba(255, 255, 255, .12);
        box-shadow: 0 25px 60px rgba(0, 0, 0, .45);
        transform: rotate(1.5deg);
        overflow: hidden;
    }
    .kk-code-bar { display: flex; gap: .4rem; padding: .75rem 1rem; background: #111a2e; }
    .kk-code-bar span { width: .7rem; height: .7rem; border-radius: 50%; }
    .kk-code-bar span:nth-child(1) { background: #ff5f57; }
    .kk-code-bar span:nth-child(2) { background: #febc2e; }
    .kk-code-bar span:nth-child(3) { background: #28c840; }
    .kk-code pre {
        margin: 0; padding: 1.25rem 1.25rem 1.5rem;
        color: #cbd5e1; font-size: .9rem; line-height: 1.7;
        font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        white-space: pre-wrap;
    }
    .kk-c-com { color: #64748b; }
    .kk-c-var { color: #5eead4; }
    .kk-c-str { color: #fcd34d; }
    .kk-c-key { color: #f472b6; }
    .kk-c-fn  { color: #60a5fa; }

    /* Kartu */
    .kk-section-title { font-weight: 800; }
    .kk-card {
        height: 100%;
        border: 1px solid rgba(0, 0, 0, .06);
        border-radius: 1.1rem;
        background: #fff;
        padding: 1.5rem;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .kk-card:hover { transform: translateY(-4px); box-shadow: 0 14px 34px rgba(15, 23, 42, .1); }
    .kk-icon {
        width: 3rem; height: 3rem; border-radius: .9rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; margin-bottom: 1rem;
        background: rgba(25, 135, 84, .12);
    }
    .kk-level {
        font-size: .75rem; font-weight: 700; letter-spacing: .03em;
        padding: .2rem .6rem; border-radius: 999px;
        background: rgba(25, 135, 84, .12); color: #146c43;
    }

    /* Langkah */
    .kk-step-no {
        width: 2.6rem; height: 2.6rem; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, #198754, #20c997);
    }

    /* Ajakan bawah */
    .kk-cta {
        border-radius: 1.5rem;
        padding: 2.5rem 2rem;
        color: #fff;
        background: linear-gradient(135deg, #198754, #0f5132);
    }

    @media (max-width: 575.98px) {
        .kk-hero { padding: 2.25rem 1.25rem; }
        .kk-code { transform: none; }
    }
</style>

{{-- ========== HERO ========== --}}
<section class="kk-hero mb-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            @auth
                <p class="mb-3 text-white-50">Halo, {{ auth()->user()->name }} 👋</p>
            @endauth

            <span class="kk-badge mb-3"><i></i> Kursus teknologi untuk mahasiswa</span>

            <h1 class="kk-title fw-bold mb-3">
                Belajar lebih terarah bersama <span class="kk-grad">Kursusku</span>
            </h1>

            <p class="lead text-white-50 mb-4">
                Pilih kursus, cek ketersediaan kursi, lalu isi formulir pendaftaran.
            </p>

            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('enrollments.create') }}" class="btn btn-success btn-lg px-4">Daftar Kursus</a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-light btn-lg px-4">Lihat Course</a>
                    @else
                        <a href="{{ route('profile.index') }}" class="btn btn-outline-light btn-lg px-4">Profil Saya</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">Login</a>
                @endauth
            </div>

            <div>
                <span class="kk-chip">Web Dasar</span>
                <span class="kk-chip">PHP Dasar</span>
                <span class="kk-chip">Laravel Dasar</span>
            </div>
        </div>

        <div class="col-lg-6 d-none d-md-block">
            <div class="kk-code">
                <div class="kk-code-bar"><span></span><span></span><span></span></div>
<pre><span class="kk-c-com">// belajar.php</span>
<span class="kk-c-var">$kursus</span> = <span class="kk-c-str">"Laravel Dasar"</span>;
<span class="kk-c-var">$kursi</span>  = <span class="kk-c-fn">cekKursi</span>(<span class="kk-c-var">$kursus</span>);

<span class="kk-c-key">if</span> (<span class="kk-c-var">$kursi</span> &gt; 0) {
    <span class="kk-c-fn">daftar</span>(<span class="kk-c-var">$nama</span>, <span class="kk-c-var">$kursus</span>);
    <span class="kk-c-fn">echo</span> <span class="kk-c-str">"Selamat belajar!"</span>;
}</pre>
            </div>
        </div>
    </div>
</section>

{{-- ========== KEUNGGULAN ========== --}}
<section class="mb-5">
    <div class="text-center mb-4">
        <h2 class="kk-section-title h3 mb-1">Kenapa belajar di Kursusku?</h2>
        <p class="text-muted mb-0">Proses daftar dibuat sederhana supaya Anda bisa fokus belajar.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="kk-card">
                <div class="kk-icon">📚</div>
                <h3 class="h5 fw-bold">Materi terarah</h3>
                <p class="text-muted mb-0">Mulai dari dasar web, PHP, hingga Laravel dengan urutan belajar yang jelas.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="kk-card">
                <div class="kk-icon">🪑</div>
                <h3 class="h5 fw-bold">Cek kursi langsung</h3>
                <p class="text-muted mb-0">Lihat sisa kursi sebelum mendaftar, tanpa perlu menebak kuota yang tersedia.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="kk-card">
                <div class="kk-icon">📝</div>
                <h3 class="h5 fw-bold">Daftar mudah</h3>
                <p class="text-muted mb-0">Cukup isi satu formulir pendaftaran, lalu data Anda langsung tercatat.</p>
            </div>
        </div>
    </div>
</section>

{{-- ========== PROGRAM ========== --}}
<section class="mb-5">
    <div class="text-center mb-4">
        <h2 class="kk-section-title h3 mb-1">Program kursus</h2>
        <p class="text-muted mb-0">Pilih program yang sesuai dengan tahap belajar Anda.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="kk-card d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fs-2">🌐</span>
                    <span class="kk-level">PEMULA</span>
                </div>
                <h3 class="h5 fw-bold">Web Dasar</h3>
                <p class="text-muted">Kenali HTML, CSS, dan cara kerja halaman web dari nol.</p>
                <a href="{{ route('enrollments.create') }}" class="btn btn-outline-success mt-auto">Daftar program</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="kk-card d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fs-2">🐘</span>
                    <span class="kk-level">DASAR</span>
                </div>
                <h3 class="h5 fw-bold">PHP Dasar</h3>
                <p class="text-muted">Pelajari logika pemrograman PHP: variabel, percabangan, dan fungsi.</p>
                <a href="{{ route('enrollments.create') }}" class="btn btn-outline-success mt-auto">Daftar program</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="kk-card d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fs-2">🚀</span>
                    <span class="kk-level">LANJUTAN</span>
                </div>
                <h3 class="h5 fw-bold">Laravel Dasar</h3>
                <p class="text-muted">Bangun aplikasi web dengan route, controller, Blade, dan database.</p>
                <a href="{{ route('enrollments.create') }}" class="btn btn-outline-success mt-auto">Daftar program</a>
            </div>
        </div>
    </div>
</section>

{{-- ========== LANGKAH DAFTAR ========== --}}
<section class="mb-5">
    <div class="text-center mb-4">
        <h2 class="kk-section-title h3 mb-1">Cara mendaftar</h2>
        <p class="text-muted mb-0">Tiga langkah singkat untuk mulai belajar.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="d-flex gap-3">
                <div class="kk-step-no">1</div>
                <div>
                    <h3 class="h6 fw-bold mb-1">Pilih kursus</h3>
                    <p class="text-muted mb-0">Tentukan program yang ingin Anda ikuti.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex gap-3">
                <div class="kk-step-no">2</div>
                <div>
                    <h3 class="h6 fw-bold mb-1">Cek ketersediaan kursi</h3>
                    <p class="text-muted mb-0">Pastikan masih ada kursi untuk kursus pilihan Anda.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex gap-3">
                <div class="kk-step-no">3</div>
                <div>
                    <h3 class="h6 fw-bold mb-1">Isi formulir</h3>
                    <p class="text-muted mb-0">Lengkapi data diri, lalu kirim pendaftaran Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========== AJAKAN ========== --}}
<section class="kk-cta text-center mb-2">
    <h2 class="h3 fw-bold mb-2">Siap mulai belajar?</h2>
    <p class="mb-4 text-white-50">Amankan kursi Anda sekarang sebelum kuota penuh.</p>
    <a href="{{ route('enrollments.create') }}" class="btn btn-light btn-lg px-4 fw-semibold">Daftar Kursus Sekarang</a>
</section>
@endsection
