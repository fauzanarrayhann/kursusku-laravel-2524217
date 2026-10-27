<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }}</title>
    <!-- Menghubungkan CSS menggunakan Helper asset() -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="navbar">
        <div class="container">
            <strong>{{ $siteName }}</strong>
            <nav>
                <a href="{{ route('home') }}" style="color: white">Beranda</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <div>
                <p>Belajar Web Secara Bertahap</p>
                <h1>Bangun kemampuan web dari PHP sampai Laravel.</h1>
                <p>Kursusku menyediakan latihan terarah untuk pemula.</p>
            </div>
            <!-- Menampilkan Gambar menggunakan Helper asset() -->
            <img src="{{ asset('images/hero-kursus.jpg') }}" alt="Ilustrasi kelas Kursusku">
        </section>

        <section>
            <h2>Kursus Pilihan</h2>
            <div class="course-grid">
                @foreach ($featured as $course)
                    <article class="card">
                        <small>{{ $course['code'] }}</small>
                        <h3>{{ $course['name'] }}</h3>
                        <p>{{ $course['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>