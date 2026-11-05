<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        // Validasi otomatis ditangani oleh StoreCourseRequest dan diambil via validated()
        Course::create($request->validated());

        return to_route('courses.index')
            ->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function show(Course $course)
    {
        // Menggunakan Route Model Binding untuk menampilkan detail kursus
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        // Menampilkan form edit dengan data kursus yang dipilih
        return view('courses.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        // Memperbarui data menggunakan data yang sudah lolos validasi UpdateCourseRequest[cite: 52, 57]
        $course->update($request->validated());

        return to_route('courses.show', $course)
            ->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        // Menghapus data kursus dari database[cite: 57, 58]
        $course->delete();

        return to_route('courses.index')
            ->with('success', 'Kursus berhasil dihapus.');
    }
}