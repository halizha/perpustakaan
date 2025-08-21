@extends('frontend.layouts.main')

@section('title', 'Detail Buku')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Detail Buku</strong>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Kolom gambar sampul --}}
                <div class="col-md-4 text-center">
                    @if ($buku->sampul)
                        <img src="{{ asset('storage/' . $buku->sampul) }}" 
                             alt="Sampul Buku"
                             class="img-fluid rounded shadow-sm mb-4"
                             style="max-height: 450px; max-width: 100%;">
                    @else
                        <p class="text-muted">Tidak ada gambar sampul</p>
                    @endif
                </div>

                {{-- Kolom detail --}}
                <div class="col-md-8">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th width="150px"><strong>Judul</strong></th>
                            <td><strong>{{ $buku->judul }}</strong></td>
                        </tr>
                        <tr>
                            <th><strong>Sinopsis</strong></th>
                            <td style="text-align: justify;">{{ $buku->sinopsis }}</td>
                        </tr>
                        <tr>
                            <th><strong>Kategori</strong></th>
                            <td>{{ $buku->kategori->nama }}</td>
                        </tr>
                        <tr>
                            <th><strong>Penulis</strong></th>
                            <td>{{ $buku->penulis }}</td>
                        </tr>
                        <tr>
                            <th><strong>Penerbit</strong></th>
                            <td>{{ $buku->penerbit }}</td>
                        </tr>
                        <tr>
                            <th><strong>Tahun</strong></th>
                            <td>{{ $buku->tahun }}</td>
                        </tr>
                        <tr>
                            <th><strong>ISBN</strong></th>
                            <td>{{ $buku->isbn }}</td>
                        </tr>
                        <tr>
                            <th><strong>Jumlah</strong></th>
                            <td>{{ $buku->jumlah }}</td>
                        </tr>
                        <tr>
                            <th><strong>Kode Rak</strong></th>
                            <td>{{ $buku->kode_rak }}</td>
                        </tr>
                        <tr>
                            <th><strong>Status</strong></th>
                            <td>
                                @if ($buku->status == 'tersedia')
                                    <span class="badge bg-success rounded-pill px-3 py-2">Tersedia</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="bi bi-book"></i> Pinjam
                            </a>
                        @else
                            {{--<form action="#" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-book"></i> Pinjam
                                </button>
                            </form>--}}
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
