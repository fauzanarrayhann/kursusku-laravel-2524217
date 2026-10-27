<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }} | Laravel MVC</title>
    <!-- Menghubungkan CSS menggunakan Helper asset() -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- HEADER BARUT (TEAL DOUBLE-DECKER) -->
    <header class="navbar">
        <!-- Row 1: Brand & Badge Milestone -->
        <div class="navbar-top">
            <div class="container navbar-flex">
                <div class="logo-area">
                    <span class="logo-box">K</span>
                    <div>
                        <span class="brand-title">{{ $siteName }}</span>
                        <span class="brand-subtitle">Laravel MVC</span>
                    </div>
                </div>
                <div>
                    <span class="milestone-badge">Milestone 7</span>
                </div>
            </div>
        </div>
        
        <!-- Row 2: Menu Navigasi & Tombol -->
        <div class="navbar-menu">
            <div class="container navbar-flex">
                <nav class="nav-links">
                    <a href="{{ route('home') }}" class="active">Beranda</a>
                    <a href="#mvc">Alur MVC</a>
                    <a href="#featured">Kursus Pilihan</a>
                </nav>
                <a href="#program" class="btn-lihat-program">Lihat Program</a>
            </div>
        </div>
    </header>

    <main class="container">
        <!-- HERO SECTION SAMA SEPERTI GAMBAR -->
        <section class="hero">
            <div class="hero-left">
                <p class="hero-tagline">PERTEMUAN 7 • FRAMEWORK LARAVEL</p>
                <h1 class="hero-heading">Belajar terstruktur dengan Route, Controller, dan Blade.</h1>
                <p class="hero-description">
                    Landing page KursusKu dipindahkan dari PHP biasa ke pola framework Laravel. 
                    Request masuk melalui route, data disiapkan controller, lalu Blade merender HTML.
                </p>
                <div class="hero-cta">
                    <a href="#featured" class="btn btn-primary">Program Belajar Unggulan</a>
                    <a href="#mvc" class="btn btn-secondary">Lihat Alur MVC</a>
                </div>
            </div>
            
            <!-- GAMBAR / ILUSTRASI DENGAN CARD BACKDROP SEPERTI DI GAMBAR -->
            <div class="hero-right">
                <div class="illustration-card">
                    <img src="{{ asset('images/hero-kursus.jpg') }}" alt="Ilustrasi Kelas KursusKu">
                </div>
            </div>
        </section>

        <!-- DAFTAR KURSUS / CARD SECTION -->
        <section id="featured" class="course-section">
            <h2 class="section-title">Kursus Pilihan</h2>
            <div class="course-grid">
                @foreach ($featured as $course)
                    <article class="card">
                        <small class="course-code">{{ $course['code'] }}</small>
                        <h3 class="course-title">{{ $course['name'] }}</h3>
                        <p class="course-desc">{{ $course['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>