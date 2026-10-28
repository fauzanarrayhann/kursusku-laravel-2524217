@extends('layouts.app')

@section('title', 'Beranda Kursusku')

@section('content')
<!-- Hero Section -->
<section class="py-4">
    <span class="badge text-bg-success mb-2">Pertemuan 9 • Framework Laravel</span>
    <h1 class="fw-bold display-5">Belajar terstruktur dengan Route, Controller, dan Blade.</h1>
    <p class="lead text-secondary">
        Landing page Kursusku menggunakan Blade layout dan Bootstrap.
    </p>
    <a href="{{ route('enrollments.create') }}" class="btn btn-success">Daftar Kursus</a>
</section>

<!-- Kursus Pilihan Section -->
<section class="mt-4">
    <h3 class="fw-bold mb-4">Kursus Pilihan</h3>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <span class="badge bg-light text-dark mb-2">WEB-01</span>
                    <h5 class="card-title fw-bold">Web Dasar</h5>
                    <p class="card-text text-muted">Belajar struktur HTML dan CSS dasar.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <span class="badge bg-light text-dark mb-2">PHP-01</span>
                    <h5 class="card-title fw-bold">PHP Dasar</h5>
                    <p class="card-text text-muted">Belajar variabel, function, form, dan logika PHP.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <span class="badge bg-light text-dark mb-2">LAR-01</span>
                    <h5 class="card-title fw-bold">Laravel Fundamental</h5>
                    <p class="card-text text-muted">Belajar route, controller, Blade, dan MVC.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection