@extends('layouts.app')

@section('title', 'Akses Ditolak - KursusKu')

@section('content')
<div class="text-center py-5">
    <div class="display-1 fw-bold text-success">403</div>
    <h1 class="h4 fw-bold mb-2">Akses ditolak</h1>
    <p class="text-muted mb-4">
        {{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk membuka halaman ini.' }}
    </p>
    <a href="{{ route('home') }}" class="btn btn-success">Kembali ke Beranda</a>
</div>
@endsection
