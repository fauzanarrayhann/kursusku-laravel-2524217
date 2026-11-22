<div id="course-results">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                <tr>
                    <td>{{ $course->code }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">
                        Tidak ada kursus yang sesuai pencarian/filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $courses->links() }}
    </div>
</div>