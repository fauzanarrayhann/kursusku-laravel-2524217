<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminOnly;

// 1. Halaman Utama / Home (bisa diakses umum)
Route::get('/', function () {
    return view('home');
})->name('home');

// 2. Route Autentikasi (Guest: hanya bisa diakses saat belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Daftar akun
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Forgot Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'resetPasswordDirect'])->name('password.update.direct');
});

// 3. Route untuk semua akun yang sudah login (role admin maupun user)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman Profil setelah berhasil login
    Route::get('/admin/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/admin/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/admin/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Formulir pendaftaran kursus (boleh untuk semua akun yang login)
    Route::resource('enrollments', EnrollmentController::class)
        ->only(['create', 'store']);

    // Ketersediaan kursus (dipakai Ajax pada formulir pendaftaran)
    Route::get('/courses/{course}/availability', function (int $course) {
        $availability = [
            1 => ['course' => 'Web Dasar', 'remaining' => 12],
            2 => ['course' => 'PHP Dasar', 'remaining' => 8],
            3 => ['course' => 'Laravel Dasar', 'remaining' => 4],
        ];

        abort_unless(isset($availability[$course]), 404);

        return response()->json($availability[$course]);
    })->name('courses.availability');

    // 4. Route KHUSUS ADMIN
    Route::middleware(AdminOnly::class)->group(function () {
        // CRUD Course
        Route::resource('courses', CourseController::class);

        // Laporan / daftar Enrollment
        Route::resource('enrollments', EnrollmentController::class)
            ->only(['index']);
    });
});
