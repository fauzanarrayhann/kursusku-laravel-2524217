<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;

// 1. Route Resource untuk Course (CRUD Course)
Route::resource('courses', CourseController::class);

// 2. Route Resource untuk Enrollment (Pertemuan 12 - Relasi Database)
// Otomatis menyediakan route untuk index (laporan), create (form), dan store (simpan)
Route::resource('enrollments', EnrollmentController::class)
    ->only(['index', 'create', 'store']);

// 3. Halaman Utama / Home
Route::get('/', function () {
    return view('home');
})->name('home');

// 4. Route Ketersediaan Kursus (dari pertemuan sebelumnya)
Route::get('/courses/{course}/availability', function (int $course) {
    $availability = [
        1 => ['course' => 'Web Dasar', 'remaining' => 12],
        2 => ['course' => 'PHP Dasar', 'remaining' => 8],
        3 => ['course' => 'Laravel Dasar', 'remaining' => 4],
    ];

    abort_unless(isset($availability[$course]), 404);

    return response()->json($availability[$course]);
})->name('courses.availability');