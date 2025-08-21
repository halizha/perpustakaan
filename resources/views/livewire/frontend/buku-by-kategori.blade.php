@extends('frontend.layouts.main')

@section('title', 'Buku Kategori: ' . $kategori->nama)

@section('content')
<div>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Perpustakaan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#kategori">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#kontak">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <div class="container py-5" style="margin-top: 90px;">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <strong>Daftar Buku - {{ $kategori->nama }}</strong>
            </div>

            <div class="card-body">
                {{-- Kembali + Search --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    <a href="{{ url('/') }}#kategori" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> 
                    </a>
                    <input type="text" wire:model.debounce.300ms="search" 
                           class="form-control flex-grow-1" 
                           placeholder="Cari buku di kategori ini...">
                </div>

                {{-- Grid Buku --}}
                @if ($buku->count())
                    <div class="row">
                        @foreach ($buku as $item)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100 shadow-sm">
                                    {{-- Sampul Buku --}}
                                    @if ($item->sampul)
                                        <img src="{{ asset('storage/' . $item->sampul) }}" 
                                             class="card-img-top" 
                                             alt="{{ $item->judul }}">
                                    @else
                                        <img src="https://via.placeholder.com/300x400?text=No+Cover" 
                                             class="card-img-top" 
                                             alt="No cover">
                                    @endif

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">
                                            {!! $search ? str_ireplace($search, '<mark>'.$search.'</mark>', $item->judul) : $item->judul !!}
                                        </h5>
                                        <p class="card-text text-muted mb-2">
                                            <small><i class="bi bi-person"></i> 
                                                {!! $search ? str_ireplace($search, '<mark>'.$search.'</mark>', $item->penulis) : $item->penulis !!}
                                            </small><br>
                                            <small><i class="bi bi-building"></i> 
                                                {!! $search ? str_ireplace($search, '<mark>'.$search.'</mark>', $item->penerbit) : $item->penerbit !!}
                                            </small>
                                        </p>
                                        <div class="mt-auto">
                                            <a href="{{ route('buku.detail', $item->id) }}" 
                                               class="btn btn-primary btn-sm w-100">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {{ $buku->links() }}
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        Data tidak ada.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
