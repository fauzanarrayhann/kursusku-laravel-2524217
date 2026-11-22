@extends('layouts.app')

@section('title', 'Daftar Kursus')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Daftar Kursus</h1>
            <p class="text-muted mb-0">Data diambil dari MySQL melalui Eloquent.</p>
        </div>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">
            + Tambah Kursus
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('courses.index') }}" class="row g-2 mb-3">
        <div class="col-md-6">
            <input
                type="search"
                id="live-search"
                name="q"
                value="{{ $search }}"
                class="form-control"
                placeholder="Cari kode atau nama kursus"
            >
        </div>

        <div class="col-md-3">
            <select id="status-filter" name="status" class="form-select">
                <option value="">Semua status</option>
                <option value="open" @selected($status === 'open')>Open</option>
                <option value="closed" @selected($status === 'closed')>Closed</option>
                <option value="draft" @selected($status === 'draft')>Draft</option>
            </select>
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <div id="course-results">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Biaya</th>
                                <th>Kuota</th>
                                <th>Mulai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                            <tr>
                                <td>{{ $course->code }}</td>
                                <td>{{ $course->name }}</td>
                                <td>Rp {{ number_format($course->fee, 0, ',', '.') }}</td>
                                <td>{{ $course->quota }}</td>
                                <td>{{ $course->start_date?->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($course->status) }}</td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        {{-- Tombol Detail ke halaman show --}}
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-primary">
                                            Detail
                                        </a>

                                        {{-- Tombol Edit ke halaman edit --}}
                                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-warning">
                                            Edit
                                        </a>

                                        {{-- Form Delete dengan konfirmasi dan method spoofing DELETE --}}
                                        <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Hapus kursus ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Tidak ada kursus yang sesuai pencarian/filter.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    if (typeof window.jQuery === 'undefined') {
        return;
    }

    let searchTimer;
    const baseUrl = @json(route('courses.index'));

    function loadCourses(url = baseUrl) {
        const q = $('#live-search').val();
        const status = $('#status-filter').val();

        $.get(url, { q, status, partial: 1 })
            .done(function (html) {
                $('#course-results').replaceWith(html);
            })
            .fail(function () {
                console.error('Gagal memuat hasil course.');
            });
    }

    $(document).on('input', '#live-search', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            loadCourses();
        }, 300);
    });

    $(document).on('change', '#status-filter', function () {
        loadCourses();
    });

    $(document).on('click', '#course-results .pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const q = $('#live-search').val();
        const status = $('#status-filter').val();

        $.get(url, { q, status, partial: 1 })
            .done(function (html) {
                $('#course-results').replaceWith(html);
            });
    });
})();
</script>
@endpush