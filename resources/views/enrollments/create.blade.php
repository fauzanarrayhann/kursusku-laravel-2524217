@extends('layouts.app')

@section('title', 'Pendaftaran Kursus')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h3 mb-3">Tambah Enrollment</h1>
                <p class="text-secondary">
                    Pilih peserta dan kursus yang tersedia untuk melakukan pendaftaran relasional.
                </p>

                <form method="POST" action="{{ route('enrollments.store') }}">
                    @csrf

                    {{-- Pilihan Participant (Relasi ke tabel participants) --}}
                    <div class="mb-3">
                        <label for="participant_id" class="form-label">Participant</label>
                        <select id="participant_id" name="participant_id" class="form-select @error('participant_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Participant --</option>
                            @foreach ($participants as $participant)
                                <option value="{{ $participant->id }}" @selected(old('participant_id') == $participant->id)>
                                    {{ $participant->name }} ({{ $participant->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('participant_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pilihan Course (Relasi ke tabel courses) --}}
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course</label>
                        <select id="course_id" name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Course --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                                    {{ $course->code }} - {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        {{-- Menampilkan pesan error validasi (termasuk pesan error duplicate peserta pada kursus yang sama) --}}
                        @error('course_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($errors->any() && !$errors->has('course_id') && !$errors->has('participant_id'))
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" type="submit">
                            Simpan Enrollment
                        </button>
                        <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary">
                            Kembali ke Laporan
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection